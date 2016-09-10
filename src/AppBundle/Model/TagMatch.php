<?php

namespace AppBundle\Model;

use AppBundle\Entity\Tag;

class TagMatch
{
    /** @var  Tag */
    private $tag;
    /** @var  MediaTag */
    private $mediaTag;

    /**
     * TagMatch constructor.
     * @param Tag $tag
     * @param MediaTag $mediaTag
     */
    public function __construct(Tag $tag, MediaTag $mediaTag)
    {
        $this->tag = $tag;
        $this->mediaTag = $mediaTag;
    }

    /**
     * @return Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @return MediaTag
     */
    public function getMediaTag()
    {
        return $this->mediaTag;
    }

    public function getScore()
    {
        return $this->mediaTag->getScore();
    }
}