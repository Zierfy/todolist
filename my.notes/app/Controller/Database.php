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

        $data = explode("\n", file_get_contents(__DIR__ . './../../../../../database_passwords/todolist_db.txt'));

        $connect = new mysqli(trim($data[0]), trim($data[1]), trim($data[2]), trim($data[3]));
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