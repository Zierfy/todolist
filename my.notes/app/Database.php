<?php

class Database
{
    public object $connect;

    public function __construct()
    {
        $this->connect = $this->dbConnect();
    }

    protected function dbConnect(): object
    {
        $connect = new mysqli('localhost', 'root', '', 'chiter');
        $connect->set_charset('utf8');

        if ($connect->connect_error) {
            echo 'Ошибка: Невозможно подключиться к MySQL ' . $connect->connect_error;
            die;
        }
        return $connect;
    }

    public function checkSql($value)
    {
        return $this->connect->real_escape_string(trim($value));
     }
}