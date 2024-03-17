<?php

class Authorization extends Database
{
    public object $connect;
    public array $errors;
    protected Checks $checks;


    public function __construct(Checks $checks)
    {
        $this->connect = parent::dbConnect();
        $this->checks = $checks;
    }


    public function checkErrors($mail, $password): array
    {
        $this->errors['noMail'] = !empty($mail) ? $this->checks->checkUniqueMail($mail) ? 'exists' : 'ПОЛЬЗОВАТЕЛЬ С ДАННЫМ e-mail НЕ ЗАРЕГИСТРИРОВАН' : 'НЕ ВВЕДЕН e-mail';
        $this->errors['noPassword'] = empty($password) ? 'НЕ ВВЕДЕН ПАРОЛЬ' : 'entered';

        return $this->errors;
    }

    public function checkPassword($mail, $password): bool
    {
        $result = $this->connect->query("SELECT password 
                                            FROM `users` 
                                            WHERE `mail` = '$mail'");
        if (!$result) {
            echo 'Произошла ошибка при выполнении запроса';
            return false;
        }
        $hash = mysqli_fetch_array($result)['password'];
        return password_verify($password, $hash);
    }

    public function joinAccount($mail): object
    {

        return $this->connect->query("SELECT u.`id`, r.`role` 
                    FROM `users` u JOIN `roles` r 
                        ON r.`uid` = u.`role_id`
                    WHERE u.`mail` = '$mail'");
    }

}