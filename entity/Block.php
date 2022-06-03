<?php

class Block {
    protected $is_important; // bool
    protected $is_pink;
    protected $is_blue;
    protected $base_class = "contentBlock";

    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getIsImportant()
    {
        return $this->is_important;
    }

    /**
     * @param mixed $is_important
     */
    public function setIsImportant($is_important): void
    {
        $this->is_important = $is_important;
    }

    /**
     * @return mixed
     */
    public function getIsPink()
    {
        return $this->is_pink;
    }

    /**
     * @param mixed $is_pink
     */
    public function setIsPink($is_pink): void
    {
        $this->is_pink = $is_pink;
    }

    /**
     * @return mixed
     */
    public function getIsBlue()
    {
        return $this->is_blue;
    }

    /**
     * @param mixed $is_blue
     */
    public function setIsBlue($is_blue): void
    {
        $this->is_blue = $is_blue;
    }

    public function getStyle() {
        $res = $this->base_class;
        if ($this->is_important) {
            $res = $res . " important";
        }
        if ($this->is_blue) {
            $res = $res . " blue";
        }
        if ($this->is_pink) {
            $res = $res . " pink";
        }
        return $res;
    }

    public function __toString()
    {
        return
            "<div class=\"".$this->getStyle()."\">
                </div>"
            ;
    }

}

class ContentBlock extends Block {
    protected $header;
    protected $content;

    /**
     * @param $header
     * @param $content
     */
    public function __construct($header, $content, $is_important = false)
    {
        $this->header = $header;
        $this->content = $content;
        $this->is_important = $is_important;
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }



    public function __toString()
    {
        return
            "<div class=\"".$this->getStyle()."\">
                    <div class=\"contentHeader\">
                    ".$this->header."
                    </div>
                    <div class=\"contentContent\">
                    ".$this->content."
                    </div>
                </div>"
        ;
    }
}

class CustomBlock extends Block {
    protected $content;

    /**
     * @param $content
     */
    public function __construct($content, $base_class = "contentBlock")
    {
        $this->content = $content;
        $this->base_class = $base_class;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function __toString()
    {
        return
            "<div class=\"".$this->getStyle()."\">
                ".$this->content."
                </div>"
            ;
    }

}

class TaskBlock extends ContentBlock {
    protected $datetime;
    protected $status;
    protected $id;

    /**
     * @param $datetime
     */
    public function __construct($header, $content, $datetime, $status, $id)
    {
        include_once 'utils/Constants.php';
        global $TASK_STATUS_NEW, $TASK_STATUS_COMPLETED, $TASK_STATUS_REVIEW;
        $this->datetime = $datetime;
        $this->header = $header;
        $this->content = $content;
        $this->id = $id;
        $this->status = $status;
        if($status == $TASK_STATUS_NEW || $status == $TASK_STATUS_REVIEW) {
            $this->is_important = true;
        }
        if ($status == $TASK_STATUS_COMPLETED) {
            $this->is_blue = true;
        }
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

    public function __toString()
    {
        return
            "<div class=\"".$this->getStyle()."\">
                    <div class=\"contentHeader\">
                    <a href = \"/showTask.php?id=".$this->id."\">".$this->header."</a>
                    </div>
                    <div class=\"contentContent\">
                    ".$this->content."
                    </div>
                    <div class='righten'>".$this->datetime."</div>
                    <br />
                    <div class='righten'>".$this->status."</div>
                    <br />
                </div>"
            ;
    }

}

class ReportBlock extends Block {
    protected $report;
    protected $comments;
    protected $task_id;
    protected $is_commentable;

    /**
     * @param $report
     * @param $comments
     */
    public function __construct($report, $comments, $task_id, $is_commentable = false)
    {
        $this->report = $report;
        $this->comments = $comments;
        $this->task_id = $task_id;
        $this->is_commentable = $is_commentable;
    }

    /**
     * @return mixed
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * @param mixed $report
     */
    public function setReport($report): void
    {
        $this->report = $report;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments): void
    {
        $this->comments = $comments;
    }


    public function __toString()
    {
        $res =  "<div class=\"".$this->getStyle()."\">
            Звіт <a href='/getReport?filename=".$this->report->getFilename()."'>".$this->report->getFilename()."</a>";

        foreach ($this->comments as $comment) {
            $res = $res .
                "<div class='contentBlock'>
                    Коментар: ".$comment->getMessage()."
                </div>";
        }
        if ($this->is_commentable) {
            $res = $res .
                "<div class='contentBlock from-fields-small'>
                <form action='/showTask.php?id=" . $this->task_id
                . "&reportId=" . $this->report->getId() . "' method=\"post\" >
                
                <label for=\"comment\">Коментар до звіту:</label><br>
                <textarea id=\"comment\" name=\"comment\"></textarea><br>
                <input type=\"submit\" value=\"Додати коментар\">
                </form>
            </div>";
        }

        $res = $res . "<div class='righten'>". $this->report->getDate() ." </div>";

        $res = $res . "</div>";
        return $res;
    }

}
?>

