<?php

class Checks extends Database
{
    public object $connect;
    public function __construct()
    {
        $this->connect = parent::dbConnect();
    }

    public function checkUniqueMail($value): bool
    {
        $mails = mysqli_fetch_all($this->connect->query("SELECT `mail` FROM `users`"));

        foreach($mails as $mail) {
            if ($mail[0] == $value) {
                return true;
            }
        }
        return false;
    }

}