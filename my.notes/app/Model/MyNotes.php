<?php

class MyNotes extends Database
{
    public object $connect;
    protected object $notes;

    public function __construct(int $id)
    {
        $this->connect = parent::dbConnect();
        $this->notes = $this->connect->query("SELECT `title`, `text` FROM `publications` WHERE `uid` = $id");
    }

    public function getData(): object
    {
        return $this->notes;
    }
}