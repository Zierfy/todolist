<?php

class Article extends Database
{
    protected object $article;

    public function __construct($id)
    {
        $this->connect = parent::dbConnect();
        $this->article = $this->connect->query("SELECT `title`, `text` 
                                                    FROM `publications` 
                                                    WHERE `id` = $id");
    }

    public function getArticle(): object
    {
        return $this->article;
    }
}