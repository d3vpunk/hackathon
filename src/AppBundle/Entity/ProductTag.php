<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductTag
 *
 * @ORM\Table(name="product_tag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductTagRepository")
 */
class ProductTag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Product", fetch="EXTRA_LAZY", inversedBy="tags")
     * @ORM\JoinTable(name="ProductTags_Products",
     *     joinColumns={@ORM\JoinColumn(name="productTagId")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="productId")}
     * )
     */
    private $products;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ProductTag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return ProductTag
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * {@inheritDoc}
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getProducts()
    {
        return $this->products;
    }
}

