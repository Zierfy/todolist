<?php

class Change extends Database
{
    public object $connect;
    public function __construct()
    {
        $this->connect = parent::dbConnect();
    }

    public function add($title, $subText, $text): bool
    {
        return $this->connect->query("INSERT INTO `best_stories` (`title`, `sub_text`, `text`)
                                            VALUES ('$title', '$subText', '$text')");
    }

    public function edit($titleToChange, $title, $subText, $text): bool
    {
        return $this->connect->query("UPDATE `best_stories`
                                            SET `title` = '$title',
                                                `sub_text` = '$subText',
                                                `text` = '$text'
                                            WHERE `title` = '$titleToChange';");
    }

    public function delete($titleToDelete): bool
    {
        return $this->connect->query("DELETE FROM `best_stories` 
                                            WHERE `title` = '$titleToDelete'");
    }

    public function changeRole($userMail,$newRole): bool
    {
        return $this->connect->query("UPDATE `users`
                                            SET `role_id` = '$newRole'
                                            WHERE `mail` = '$userMail'");
    }
}
