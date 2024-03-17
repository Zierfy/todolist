<?php

class Publications extends Database
{
    public object $connect;
    public string $first_date;
    public string $last_date;
    private string $condition;
    protected object $publications;

    public function __construct()
    {
        $this->connect = parent::dbConnect();
    }

    protected function loadPublications()
    {
        $this->publications = $this->connect->query("SELECT u.name, u.surname, u.patronymic, u.mail, p.title, p.id, p.uid, p.date 
                                                        FROM `publications` p JOIN `users` u 
                                                            ON p.uid = u.id 
                                                        WHERE `status_id` = '1' $this->condition");
    }

    public function getData(): object
    {
        return $this->publications;
    }

    public function formateSql(bool $flag)
    {
        if ($flag && (!empty($_POST['start']) && !empty($_POST['end']))) {
            $this->first_date = min($_POST['start'], $_POST['end']);
            $this->last_date = max($_POST['start'], $_POST['end']);

            $this->condition = " AND p.date > '$this->first_date' AND p.date < '$this->last_date'";
        } else {
            $result = mysqli_fetch_array($this->connect->query("SELECT MIN(date) AS min_date, MAX(date) AS max_date FROM `publications`"));

            $this->first_date = $result['min_date'];
            $this->last_date = $result['max_date'];

            $this->condition = "ORDER BY p.id DESC LIMIT 7;";
        }

        $this->loadPublications();
    }
}