<?php

class Comment {
    protected $Id;
    protected $reportId;
    protected $taskId;
    protected $message;

    /**
     * @param $Id
     * @param $reportId
     * @param $taskId
     * @param $message
     */


    public function __construct($Id, $reportId, $taskId, $message)
    {
        $this->Id = $Id;
        $this->reportId = $reportId;
        $this->taskId = $taskId;
        $this->message = $message;
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
    public function getReportId()
    {
        return $this->reportId;
    }

    /**
     * @param mixed $reportId
     */
    public function setReportId($reportId): void
    {
        $this->reportId = $reportId;
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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    public function __toString()
    {
        return "Comment: (id: " . $this->Id . ", reportId: "
            . $this->reportId . ", taskId: " . $this->taskId . ", content: ".
            $this->message . ")";
    }


}

?>