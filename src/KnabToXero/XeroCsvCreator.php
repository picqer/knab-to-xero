<?php

namespace Picqer\KnabToXero;

class XeroCsvCreator
{
    private $config = array(
        'csv-delimiter' => ',',
        'csv-enclosure' => ''
    );

    public function createCsv(XeroRecordCollection $records)
    {
        $csv = [];
        $csv[] = $this->config['csv-enclosure'] . 'Date' . $this->config['csv-enclosure'] . $this->config['csv-delimiter'] .
            $this->config['csv-enclosure'] . 'Amount' . $this->config['csv-enclosure'] . $this->config['csv-delimiter'] .
            $this->config['csv-enclosure'] . 'Payee' . $this->config['csv-enclosure'] . $this->config['csv-delimiter'] .
            $this->config['csv-enclosure'] . 'Description' . $this->config['csv-enclosure'] . $this->config['csv-delimiter'] .
            $this->config['csv-enclosure'] . 'Reference' . $this->config['csv-enclosure'] . $this->config['csv-delimiter'];

        foreach ($records as $record)
        {
            $row = $this->config['csv-enclosure'] . $record->getXeroStyleDate() . $this->config['csv-enclosure'];
            $row .= $this->config['csv-delimiter'] . $this->config['csv-enclosure'] . $record->getAmount() . $this->config['csv-enclosure'];
            $row .= $this->config['csv-delimiter'] . $this->config['csv-enclosure'] . $record->getPayee() . $this->config['csv-enclosure'];
            $row .= $this->config['csv-delimiter'] . $this->config['csv-enclosure'] . $record->getDescription() . $this->config['csv-enclosure'];
            $row .= $this->config['csv-delimiter'] . $this->config['csv-enclosure'] . $record->getReference() . $this->config['csv-enclosure'];

            $csv[] = $row;
        }

        return implode("\r\n", $csv);
    }
}