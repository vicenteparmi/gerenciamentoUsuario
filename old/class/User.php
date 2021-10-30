<?php

class User
{
    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct(string $name, string $email, string $login, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->login = $login;
        $this->password = $password;
    }

    // Setters and getters
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    // Check if logged
    public function logar()
    {
        return isset($_SESSION['user']);
    }
}
