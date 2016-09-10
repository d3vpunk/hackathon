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

    private $score;

    /**
     * MediaTag constructor.
     * @param $name
     */
    public function __construct($name, $score)
    {
        $this->name = $name;
        $this->score = $score;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function getScore()
    {
        return $this->score;
    }
}