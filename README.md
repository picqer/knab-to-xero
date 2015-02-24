# Knab to Xero CSV file converter
Knab is a Dutch bank where you can export your transactions to a CSV file. This script can convert this Knab CSV file to a file that is the right format for Xero to import as a bank transactions file.

## Usage
You can use the provided index.php to convert files in your webbrowser, or use the classes to create your own converter.

## Example
    $knabExtractor = new \Picqer\KnabToXero\KnabExtractor();
    $knabRecords = $knabExtractor->extractCSV(file_get_contents('example.csv'));

    $converter = new \Picqer\KnabToXero\KnabToXeroConverter();
    $xeroRecordCollection = $converter->convertArray($knabRecords);

    $csvCreator = new \Picqer\KnabToXero\XeroCsvCreator();

    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename=XeroBankImport' . date('YmdHi') . '.csv');
    header('Pragma: no-cache');
    header('Expires: 0');
    echo $csvCreator->createCsv($xeroRecordCollection);