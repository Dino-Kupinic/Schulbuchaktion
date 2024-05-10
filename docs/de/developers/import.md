# XLSX-Import

## PHPSpreadsheet

Die Bibliothek **PHPSpreadsheet** wird zum Parsen der jährlichen Schulbuchaktion XLSX-Dateien verwendet.
Die Operationen werden über den `ImportService` durchgeführt.

Um die Leistung zu verbessern, wird der `BookBatchProcessorService` verwendet, um die Daten in Batches zu verarbeiten.

## Importieren

Die Datei wird nicht auf dem Server gespeichert, sondern direkt aus der Anfrage gelesen. Nach der Verarbeitung wird sie verworfen.

```php
$filePath = $uploadedFile->getPathname();
$data = $importService->parseFile($filePath);

// ...

unset($data[0]); // Kopfzeile entfernen
$importService->persist($data, $year);
```

## Re-Importieren

Wenn das ausgewählte Jahr bereits Daten enthält, werden alle Buchdaten gelöscht.
Der Import wird dann wie gewohnt gestartet.
Die Löschung erfolgt auch über die Stapelverarbeitung.

## Chunking

Bei der Batch-Verarbeitung werden die Einfügeanweisungen in Chunks gruppiert.
Sie können die Chunk-Größe im `ImportService` ändern:

```php
$chunkSize = 200;
$chunks = array_chunk($data, $chunkSize);
```
