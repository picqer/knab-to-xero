<?php

namespace Picqer\KnabToXero;

class IcsExtractor {
    private $records = array();

    private $config = array(
        'csv-row-endings'     => "\n",
        'csv-field-delimiter' => ';',
        'csv-field-enclosure' => ''
    );

    private $fields = array(
        'date',
        'currency-date',
        'description',
        'name-card-holder',
        'card-number',
        'credit-debit',
        'amount',
        'merchant-category',
        'country',
        'source-currency',
        'amount-in-source-currency'
    );

    public function __construct($config = array())
    {
        $this->setConfig($config);
    }

    public function extractCSV($csv)
    {
        $cleanCSV = $this->cleanup($csv);

        $rows = $this->splitRows($cleanCSV);

        foreach ($rows as $row)
        {
            $cells = $this->splitCells($row);

            if ( ! empty($cells))
            {
                $this->records[] = $this->annotateCells($cells);
            }
        }

        return $this->records;
    }

    private function cleanup($contents)
    {
        return trim($contents);
    }

    private function splitRows($contents)
    {
        $rows = explode($this->config['csv-row-endings'], $contents);
        array_shift($rows); // Remove header row

        return $rows;
    }

    private function splitCells($row)
    {
        return str_getcsv($row, $this->config['csv-field-delimiter'], $this->config['csv-field-enclosure']);
    }

    private function setConfig($config)
    {
        foreach ($config as $key => $value)
        {
            $this->config[$key] = $value;
        }
    }

    private function annotateCells($cells)
    {
        $annotatedCells = array();
        foreach ($cells as $key => $value)
        {
            if (isset($this->fields[$key]))
            {
                $annotatedCells[$this->fields[$key]] = $this->cleanCell($this->fields[$key], $value);
            }
        }

        return $annotatedCells;
    }

    private function cleanCell($cellName, $value)
    {
        $value = trim($value);

        if ($cellName == 'amount' || $cellName == 'amount-in-source-currency')
        {
            $value = str_replace(',', '.', str_replace('.', '', $value)); // Amounts are shown as: 1.262,00
        }

        $value = str_replace(',', '', $value); // Xero cannot handle comma's

        if ($cellName == 'date' || $cellName == 'currency-date')
        {
            $value = date('Y-m-d', strtotime($value));
        }

        return $value;
    }
}