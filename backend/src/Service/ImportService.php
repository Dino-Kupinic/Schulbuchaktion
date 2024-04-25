<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportService
{
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

  public function persist(array $data)
  {
  }
}


