<?php

class Task {
    protected $Id; // Unique numeric value (int)
    protected $employeeId; // ID виконавця (int)
    protected $employerId; // ID замовника (int)
    protected $header; // Header of the task (text)
    protected $description; // Description of the task (text)
    protected $datetime;
    protected $status;

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

    /**
     * @param $Id
     * @param $employeeId
     * @param $employerId
     * @param $header
     * @param $description
     */
    public function __construct($Id, $employeeId, $employerId, $header, $description, $datetime, $status)
    {
        $this->Id = $Id;
        $this->employeeId = $employeeId;
        $this->employerId = $employerId;
        $this->header = $header;
        $this->description = $description;
        $this->datetime = $datetime;
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
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * @param mixed $employeeId
     */
    public function setEmployeeId($employeeId): void
    {
        $this->employeeId = $employeeId;
    }

    /**
     * @return mixed
     */
    public function getEmployerId()
    {
        return $this->employerId;
    }

    /**
     * @param mixed $employerId
     */
    public function setEmployerId($employerId): void
    {
        $this->employerId = $employerId;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header): void
    {
        $this->header = $header;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    } // Description of the task (text)

    public function __toString()
    {
        return "Task: (id: " . $this->Id . ", employee: "
            . $this->employeeId . ", employer: " . $this->employerId . ", header: ".
            $this->header . ", description: " . $this->description . ", datetime: " . $this->datetime
            .", status: ". $this->status. ")";
    }
}

?>