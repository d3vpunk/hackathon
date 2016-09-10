<?php

namespace AppBundle\Model;

/**
 *
 * Created by PhpStorm.
 * User: johannes
 * Date: 9/10/16
 * Time: 10:05 AM
 */
class MediaTag
{
    private $name;

    private $tag;

    /**
     * MediaTag constructor.
     * @param $name
     * @param $tag
     */
    public function __construct($name, $tag)
    {
        $this->name = $name;
        $this->tag = $tag;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }
}