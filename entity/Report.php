<?php

class Report {
    protected $Id; // Unique numeric value
    protected $taskId; // Id of linked task
    protected $filename; // Generated name of report file
    protected $date; // DateTime of sending

    /**
     * @param $Id
     * @param $taskId
     * @param $filename
     * @param $date
     */
    public function __construct($Id, $taskId, $filename, $date)
    {
        $this->Id = $Id;
        $this->taskId = $taskId;
        $this->filename = $filename;
        $this->date = $date;
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
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * @param mixed $taskId
     */
    public function setTaskId($taskId): void
    {
        $this->taskId = $taskId;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function __toString()
    {
        return "Report: (id: " . $this->Id . ", task(Id): "
            . $this->taskId . ", filename: " . $this->filename . ", date: ".
            $this->date . ")";
    }
}

?>