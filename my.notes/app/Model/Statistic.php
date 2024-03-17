<?php

class Statistic extends Database
{
    public object $connect;
    public function __construct()
    {
        $this->connect = parent::dbConnect();
    }

    public function getStatistic(string $sql)
    {
        $result = mysqli_fetch_all($this->connect->query($sql));

        $statistic = [
            'total' => count($result),
            'total_public' => 0,
            'total_private' => 0,
            'total_protected' => 0
        ];

        foreach ($result as $value) {
            if ($value[0] == '1') {
                $statistic['total_public'] += 1;
            } elseif ($value[0] == '2') {
                $statistic['total_private'] += 1;
            } else {
                $statistic['total_protected'] += 1;
            }
        }
        return $statistic;
    }
}
