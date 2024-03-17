<?php

class Human extends Database
{
    public object $connect;
    protected object $user;
    protected object $publications;

    public function __construct(int $id)
    {
        $this->connect = parent::dbConnect();

        if ($id != 0) {
            $this->user = $this->connect->query("SELECT DISTINCT u.name, u.surname, u.patronymic, u.age, u.mail 
                                                FROM `publications` p JOIN `users` u 
                                                    ON p.uid = u.id 
                                                WHERE p.uid = $id");
            $this->publications = $this->connect->query("SELECT title, text, id FROM `publications` 
                                                        WHERE uid = $id");
        }
    }

    public function getUser(): object
    {
        return $this->user;
    }
    public function getPublications(): object
    {
        return $this->publications;
    }
}