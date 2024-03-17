<?php

class Story extends Database
{
    public object $connect;
    protected object $story;

    public function __construct($chpu)
    {
        $this->connect = parent::dbConnect();
        $this->story = $this->connect->query("SELECT `title`, `text` 
                                                FROM `best_stories` 
                                                WHERE `chpu` = '$chpu'");
    }

    public function getStory(): object
    {
        return $this->story;
    }

}