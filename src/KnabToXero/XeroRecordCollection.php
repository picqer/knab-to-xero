<?php

namespace Picqer\KnabToXero;

class XeroRecordCollection implements \Iterator
{
    private $position = 0;
    private $xeroRecords = array();

    public function addRecord(XeroRecord $record)
    {
        $this->xeroRecords[] = $record;
    }

    public function getRecords()
    {
        return $this->xeroRecords;
    }

    public function __construct() {
        $this->position = 0;
    }

    public function rewind() {
        $this->position = 0;
    }

    public function current() {
        return $this->xeroRecords[$this->position];
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function valid() {
        return isset($this->xeroRecords[$this->position]);
    }
}