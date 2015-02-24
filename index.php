<?php

require 'vendor/autoload.php';

function dd($contents)
{
    var_dump($contents);
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $knabExtractor = new \Picqer\KnabToXero\KnabExtractor();
    $knabRecords = $knabExtractor->extractCSV(file_get_contents($_FILES['csvfile']['tmp_name']));

    $converter = new \Picqer\KnabToXero\KnabToXeroConverter();
    $xeroRecordCollection = $converter->convertArray($knabRecords);

    $csvCreator = new \Picqer\KnabToXero\XeroCsvCreator();

    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename=XeroBankImport' . date('YmdHi') . '.csv');
    header('Pragma: no-cache');
    header('Expires: 0');
    echo $csvCreator->createCsv($xeroRecordCollection);
    die();
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Knab to Xero converter</title>
    <style>
        body {
            font-family: "Arial", "Helvetica", sans-serif;
            font-size: 0.8em;
            line-height: 1.4em;
        }
    </style>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Knab to Xero converter</h1>
            <p>Convert your Knab CSV file to a Xero CSV file.</p>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <p>
                <label for="csvfile">Knab CSV file</label><br>
                <input type="file" id="csvfile" name="csvfile">
            </p>
            <p><input type="submit" value="Convert to Xero CSV" class="btn btn-primary"></p>
        </form>
    </div>
</body>
</html>
