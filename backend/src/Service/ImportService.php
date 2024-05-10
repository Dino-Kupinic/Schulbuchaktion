<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Subject;
use App\Entity\Year;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Service class for handling import of books from a xlsx file.
 *
 * @author Dino Kupinic
 * @version 1.0
 */
class ImportService
{
  private BookService $bookService;
  private PublisherService $publisherService;
  private SubjectService $subjectService;

  public function __construct(BookService $bookService, PublisherService $publisherService, SubjectService $subjectService)
  {
    $this->bookService = $bookService;
    $this->publisherService = $publisherService;
    $this->subjectService = $subjectService;
  }

  /**
   * Parses the xlsx file and returns the data as a 2D array
   *
   * @param string $filePath
   * @return array array containing the xlsx data (2D array for the rows and columns)
   */
  public function parseFile(string $filePath): array
  {
    $spreadsheet = IOFactory::load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();

    $data = [];
    foreach ($worksheet->getRowIterator() as $row) {
      $rowData = [];
      foreach ($row->getCellIterator() as $cell) {
        $rowData[] = $cell->getValue();
      }
      $data[] = $rowData;
    }
    return $data;
  }

  /**
   * checks partially if the header is correct
   *
   * @param array $header first entry returned from `ImportService->parseFile()`
   * @return bool
   */
  public function isHeaderValid(array $header): bool
  {
    // this header is partial because some fields are "dynamic", though this check should be deterministic enough.
    $correctHeader = ["BNR", "Kurztitel", "Titel", "Listtyp", "Schulform", "Gegenstand", "Jahrgang", "Lehrerexemplar", "Anmerkung", "VNR", "Verlag", "Hauptbuch"];
    $intersect = array_intersect($correctHeader, $header);
    return count($intersect) === count($correctHeader);
  }

  /**
   * Extracts the data from a single row of the xlsx file
   *
   * @param array $row single row from the xlsx file
   * @return array associative array with the data from the row
   */
  private function getRowData(array $row): array
  {
    return [
      'orderNumber' => $row[0],
      'shortTitle' => $row[1],
      'title' => $row[2],
      'listType' => $row[3], // unused
      'schoolForm' => $row[4],
      'subject' => $row[5],
      'grade' => $row[6],
      'teacherCopy' => $row[7],
      'description' => $row[8],
      'publisherNumber' => $row[9],
      'publisherName' => $row[10],
      'mainBookOrderNumber' => $row[11], // unused
      'price' => $row[12],
      'priceBase' => $row[13],
      'priceEbookPlus' => $row[14], // unused
      'hasEbook' => $row[15],
      'hasEbookPlus' => $row[16],
      'hasEbookSolo' => $row[17], // unused
      'hasEbookPlusSolo' => $row[18], // unused
    ];
  }

  /**
   * Converts a price in euros to cents
   *
   * @param $euroString string the price in euros
   * @return float the price in cents
   */
  public function euroToCents(string $euroString): float
  {
    $euroString = preg_replace("/[^0-9.]/", "", $euroString);
    return round(floatval($euroString) * 100);
  }

  /**
   * Persists the data from the xlsx file into the database
   *
   * @param array $data 2D array containing the xlsx data
   * @param Year $year year for which the data is being imported
   * @return void
   * @throws Exception if an error occurs while persisting the data
   */
  public function persist(array $data, Year $year): void
  {
    try {
      foreach ($data as $row) {
        $rowData = $this->getRowData($row);

        $book = new Book();

        $book->setOrderNumber($rowData['orderNumber']);
        $book->setShortTitle($rowData['shortTitle']);
        $book->setTitle($rowData['title']);
        $book->setSchoolForm($rowData['schoolForm']);
        $book->setGrade($rowData['grade']);
        $book->setDescription($rowData['description']);
        $book->setBookPrice($rowData['priceBase'] ? $this->euroToCents($rowData['priceBase']) : $this->euroToCents($rowData['price']));
        $book->setEbook($rowData['hasEbook'] === "vorhanden");
        $book->setEbookPlus($rowData['hasEbookPlus'] === "vorhanden");

        $subject = $this->subjectService->findSubjectByName($rowData['subject']);
        if (!$subject) {
          $subject = new Subject();
          $subject->setName($rowData['subject']);
          $subject->addBook($book);
          $temp = $this->subjectService->createSubject($subject);
          $book->setSubject($temp);
        } else {
          $subject->addBook($book);
          $book->setSubject($subject);
        }

        $publisher = $this->publisherService->findPublisherByNumber($rowData['publisherNumber']);
        if (!$publisher) {
          $publisher = new Publisher();
          $publisher->setPublisherNumber($rowData['publisherNumber']);
          $publisher->setName($rowData['publisherName']);
          $publisher->addBook($book);
          $temp = $this->publisherService->createPublisher($publisher);
          $book->setPublisher($temp);
        } else {
          $publisher->addBook($book);
          $book->setPublisher($publisher);
        }

        $year->addBook($book);
        $book->setYear($year);
        $this->bookService->createBook($book);
      }
    } catch (Exception $e) {
      throw new Exception("Error while persisting data: " . $e->getMessage());
    }
  }
}

