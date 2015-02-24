<?php

namespace Picqer\KnabToXero;

class KnabToXeroConverter
{
    public function convertRecord($knabRecord)
    {
        $xeroRecord = new XeroRecord();

        $xeroRecord->setDate($knabRecord['date']);
        if ($knabRecord['credit-debit'] == 'D')
        {
            $amount = 0 - $knabRecord['amount'];
        } else {
            $amount = $knabRecord['amount'];
        }
        $xeroRecord->setAmount($amount);
        $xeroRecord->setPayee($knabRecord['payee-name']);
        $xeroRecord->setDescription($knabRecord['description']);
        $xeroRecord->setReference($knabRecord['address']);

        return $xeroRecord;
    }

    public function convertArray($knabRecords)
    {
        $xeroRecordCollection = new XeroRecordCollection();

        foreach ($knabRecords as $knabRecord)
        {
            $xeroRecordCollection->addRecord($this->convertRecord($knabRecord));
        }

        return $xeroRecordCollection;
    }
}