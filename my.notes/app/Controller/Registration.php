<?php

class Registration extends Database
{
    public object $connect;
    public array $errors;
    protected Checks $checks;

    public function __construct(Checks $checks)
    {
        $this->connect = parent::dbConnect();
        $this->checks = $checks;
    }

    public function setUser($surname, $name, $patronymic, $age, $mail, $password, $role_id)
    {
        $this->connect->query("INSERT INTO `users`(`surname`, `name`, `patronymic`, `age`, `mail`, `password`, `role_id`) 
                                    VALUES ('$surname', '$name', '$patronymic', $age, '$mail', '$password', $role_id)");
    }

    protected function checkEqual($password, $verifyPassword): bool
    {
        return $password == $verifyPassword;
    }

    public function checkErrors($personalData): array
    {
        $this->errors['noSurname'] = empty($personalData['surname']) ? 'НЕ ВВЕДЕНА ФАМИЛИЯ' : '';
        $this->errors['noName'] = empty($personalData['name']) ? 'НЕ ВВЕДЕНО ИМЯ' : '';
        $this->errors['noAge'] = empty($personalData['age']) ? 'НЕ ВВЕДЕН ВОЗРАСТ' : '';
        $this->errors['noMail'] = !empty($personalData['mail']) ? $this->checks->checkUniqueMail($personalData['mail']) ? 'ПОЛЬЗОВАТЕЛЬ С ТАКИМ e-mail УЖЕ ЗАРЕГИСТРИРОВАН' : '' : 'НЕ ВВЕДЕН e-mail';
        $this->errors['noPassword'] = empty($personalData['password']) ? 'НЕ ВВЕДЕН ПАРОЛЬ' : '';
        $this->errors['noVerifyPassword'] = empty($personalData['verifyPassword']) ? 'НЕ ВВЕДЕН ПРОВЕРОЧНЫЙ ПАРОЛЬ' : '';



        if (!empty($personalData['password']) && !empty($personalData['verifyPassword'])) {
            $this->errors['notEqual'] = $this->checkEqual($personalData['password'], $personalData['verifyPassword']) ? 'equal' : 'ПАРОЛИ НЕ СОВПАДАЮТ';
        }
        return $this->errors;
    }

}
