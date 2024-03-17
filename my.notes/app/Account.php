<?php

class Account extends Database
{
    public object $connect;
    protected object $user;
    protected object $notes;

    public function __construct(int $id)
    {
        $this->connect = parent::dbConnect();
        $this->user = $this->connect->query("SELECT `name`, `surname`, `age`, `patronymic`, `mail` 
                                                FROM `users` 
                                                WHERE `id` = $id");
        $this->notes = $this->connect->query("SELECT p.`id`, p.`uid`, p.`title`, p.`text`, ps.`status`, p.`status_id` 
                                                FROM `publications` p JOIN `publish_status` ps
                                                    ON ps.`id` = p.`status_id`
                                                WHERE `uid` = $id;");
    }

    public function addNote(int $uid, string $title, string $text, string $status): bool
    {
        switch ($status) {
            case 'public':
                $status = 1;
                break;
            case 'private':
                $status = 2;
                break;
            case 'protected':
                $status = 3;
                break;
        }

        $date = date('Y-m-d H:i:s', time());

        $result = $this->connect->query("INSERT INTO `publications`(`uid`, `title`, `text`, `status_id`, `date`) 
                                    VALUES ($uid, '$title', '$text', $status, '$date')");

        return $result;
    }

    public function editNote(string $oldTitle, string $newStatus): bool
    {
        switch ($newStatus) {
            case 'public':
                $newStatus = 1;
                break;
            case 'private':
                $newStatus = 2;
                break;
            case 'protected':
                $newStatus = 3;
                break;
        }

        foreach(mysqli_fetch_all($this->notes) as $note){
            if ($note[2] == $oldTitle) {
                $result = $this->connect->query("UPDATE `publications`
                                            SET `status_id` = '$newStatus'
                                            WHERE `title` = '$oldTitle'");
                if (!$result) {
                    echo 'Ошибка при запросе';
                    break;
                }
                return true;
            }
        }
        return false;
    }

    public function getUser(): object
    {
        return $this->user;
    }

    public function getNotes(): object
    {
        return $this->notes;
    }
}