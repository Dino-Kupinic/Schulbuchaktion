<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Service class for handling import of books from an xlsx file.
 * @author Dino Kupinic
 * @version 1.0
 */
class ImportService
{
  private BookService $bookService;

  public function __construct(BookService $bookService)
  {
    $this->bookService = $bookService;
  }
  /**
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

  private function getBookData(array $row): array
  {
    return [
      'orderNumber' => $row[0],
      'shortTitle' => $row[1],
      'title' => $row[2],
      'listType' => $row[3],
      'schoolForm' => $row[4],
      'subject' => $row[5],
      'grade' => $row[6],
      'teacherCopy' => $row[7],
      'note' => $row[8],
      'vnr' => $row[9],
      'publisher' => $row[10],
      'mainBook' => $row[11]
    ];
  }

  public function persist(array $data, int $yearId): void
  {
//    foreach ($data as $row) {
//      $bookData = $this->getBookData($row);
//      $this->bookService->createBook($bookData);
//    }
  }
}


