<?php

namespace Picqer\KnabToXero;

class IcsToXeroConverter
{
    public function convertRecord($icsRecord)
    {
        $xeroRecord = new XeroRecord();

        $xeroRecord->setDate($icsRecord['date']);
        if ($icsRecord['credit-debit'] == 'D')
        {
            $amount = 0 - $icsRecord['amount'];
        } else {
            $amount = $icsRecord['amount'];
        }
        $xeroRecord->setAmount($amount);
        $xeroRecord->setPayee($icsRecord['description']);
        $xeroRecord->setDescription($icsRecord['description']);
        $xeroRecord->setReference($icsRecord['merchant-category']);

        return $xeroRecord;
    }

    public function convertArray($icsRecords)
    {
        $xeroRecordCollection = new XeroRecordCollection();

        foreach ($icsRecords as $icsRecord)
        {
            $xeroRecordCollection->addRecord($this->convertRecord($icsRecord));
        }

        return $xeroRecordCollection;
    }
}