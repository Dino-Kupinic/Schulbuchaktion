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


## Year for Import
While Importing, the user can choose which year the import is designated to.
Viable options for this year range 2 years back and 1 year forward from the current year.
If the next year is not inserted into the database already, it gets inserted.
The logic for this process is executed everytime the user visits the `/import` page.

You can change the range of years which a user can select in the `YearsRepository`
by changing the `$pastYears` variable or the `setMaxResults` parameter:
```php
public function findAllForImport($currentYear): array
    {
      $pastYears = 2;

        return $this->createQueryBuilder('y')
            ->andWhere('y.year >= :val')
            ->setParameter('val', $currentYear - $pastYears)
            ->orderBy('y.year', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }
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
