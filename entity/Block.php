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

    /**
     * @param $datetime
     */
    public function __construct($header, $content, $datetime, $status)
    {
        include_once 'utils/Constants.php';
        global $TASK_STATUS_NEW, $TASK_STATUS_COMPLETED;
        $this->datetime = $datetime;
        $this->header = $header;
        $this->content = $content;
        if($status == $TASK_STATUS_NEW) {
            $this->is_important = true;
        }
        if ($status == $TASK_STATUS_COMPLETED) {
            $this->is_blue = true;
        }
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
                    ".$this->header."
                    </div>
                    <div class=\"contentContent\">
                    ".$this->content."
                    </div>
                </div>"
            ;
    }

}

?>

