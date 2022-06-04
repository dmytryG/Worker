<?php

class Feedback {
    protected $id;
    protected $email;
    protected $feedback;
    protected $datetime;

    /**
     * @param $id
     * @param $email
     * @param $feedback
     * @param $datetime
     */
    public function __construct($id, $email, $feedback, $datetime)
    {
        $this->id = $id;
        $this->email = $email;
        $this->feedback = $feedback;
        $this->datetime = $datetime;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @param mixed $feedback
     */
    public function setFeedback($feedback): void
    {
        $this->feedback = $feedback;
    }

    /**
     * @return mixed
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param mixed $datetime
     */
    public function setDatetime($datetime): void
    {
        $this->datetime = $datetime;
    }




}

?>
