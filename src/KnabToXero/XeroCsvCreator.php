<?php

namespace Picqer\KnabToXero;

class XeroCsvCreator
{
    public function createCsv(XeroRecordCollection $records)
    {
        $csv = [];
        $csv[] = '"Date";"Amount";"Payee";"Description";"Reference"';

        foreach ($records as $record)
        {
            $row = '"' . $record->getXeroStyleDate() . '"';
            $row .= ';"' . $record->getAmount() . '"';
            $row .= ';"' . $record->getPayee() . '"';
            $row .= ';"' . $record->getDescription() . '"';
            $row .= ';"' . $record->getReference() . '"';

            $csv[] = $row;
        }

        return implode("\r\n", $csv);
    }
}