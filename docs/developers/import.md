# XLSX Import

## PHPSpreadsheet

The library **PHPSpreadsheet** is used for parsing the yearly Schulbuchaktion XLSX-files.
Operations are done via the `ImportService`.

To improve performance, the `BookBatchProcessorService` is used to process the data in batches.

## Importing

The file is not stored on the server, but is read directly from the request. It is discarded after processing.

```php
$filePath = $uploadedFile->getPathname();
$data = $importService->parseFile($filePath);

// ...

unset($data[0]); // remove header
$importService->persist($data, $year);
```

## Re-Importing

If the selected year already has data, all book data is deleted.
The import is then started as usual.
Deletion is also done via Batch processing.

## Chunking

For batch processing, insert statements are grouped together in chunks.
You can change the chunk size in the `ImportService`:

```php
$chunkSize = 200;
$chunks = array_chunk($data, $chunkSize);
```
