<?php

class BestStories extends Database
{
    public object $connect;
    protected object $bestStories;
    protected object $titlesAllStories;
    public function __construct()
    {
        $this->connect = parent::dbConnect();
        $this->bestStories = $this->connect->query("SELECT `title`, `sub_text`, `chpu` 
                                                        FROM `best_stories` 
                                                        ORDER BY `id` LIMIT 3");
        $this->titlesAllStories = $this->connect->query("SELECT `title`
                                                            FROM `best_stories`");
    }

    public function getBestStories(): object
    {
        return $this->bestStories;
    }

    public function getTitlesAllStories(): object
    {
        return $this->titlesAllStories;
    }
}
