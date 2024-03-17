<?php

class HumanSettings extends Database
{
    public object $connect;
    protected object $mailsAllUsers;
    protected object $rolesAllUsers;

    public function __construct()
    {
        $this->connect = parent::dbConnect();
    }

    public function loadMailsAllUsers()
    {
        $this->mailsAllUsers = $this->connect->query("SELECT `mail` FROM `users`");
    }

    public function loadRolesAllUsers()
    {
        $this->rolesAllUsers = $this->connect->query("SELECT r.`role` FROM `users` u JOIN `roles` r ON r.`uid` = u.`role_id`");
    }

    public function getMailsAllUsers(): object
    {
        return $this->mailsAllUsers;
    }

    public function getRolesAllUsers(): object
    {
        return $this->rolesAllUsers;
    }
}