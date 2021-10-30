<?php

class Contact
{
    private $id;
    private $name;
    private $user;
    private $emails = [];
    private $phones = [];

    public function __construct($name, User $user)
    {
        $this->name = $name;
        $this->user = $user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getEmails()
    {
        return $this->emails;
    }

    public function getPhones()
    {
        return $this->phones;
    }

    public function addEmail($email)
    {
        $this->emails[] = $email;
    }

    public function addPhone($phone)
    {
        $this->phones[] = $phone;
    }

    public function list()
    {
        echo '<ul>';
        echo '<li>' . $this->name . '</li>';
        echo '<li>' . $this->user->getName() . '</li>';
        echo '<li>' . implode(', ', $this->emails) . '</li>';
        echo '<li>' . implode(', ', $this->phones) . '</li>';
        echo '</ul>';
    }
}