<?php

Class User {

    protected $Id; // Unique numeric value
    protected $username; // String of username
    protected $status; // Just numeric value

    /**
     * @param $Id
     * @param $username
     * @param $status
     */
    public function __construct($Id, $username, $status)
    {
        $this->Id = $Id;
        $this->username = $username;
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setId($Id): void
    {
        $this->Id = $Id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }


    public function __toString()
    {
        return "User: (id: " . $this->Id . ", username: " . $this->username . ", status: " . $this->status . ")";
    }
}

?>