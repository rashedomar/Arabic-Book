<?php

namespace Core;

/**
 * Class Html
 */
class Html
{
    /**
     * the HTML title
     *
     * @var
     */
    private $title;

    /**
     * the HTML description
     *
     * @var
     */
    private $desc;

    /**
     * the HTML keywords
     *
     * @var
     */
    private $keywords;

    /**
     * get the current title
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * set the html title
     *
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * get the current description
     *
     * @return mixed
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * set the html description
     *
     * @param $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    /**
     * get the current keywords
     *
     * @return mixed
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * set the html keywords
     *
     * @param $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }
}

?>
