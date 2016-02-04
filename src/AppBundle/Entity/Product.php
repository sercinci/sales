<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Product
{
    const BASIC_TAX = 10;
    const IMPORT_TAX = 5;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal")
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tax", type="boolean")
     */
    private $tax;

    /**
     * @var boolean
     *
     * @ORM\Column(name="imported", type="boolean")
     */
    private $imported;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
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
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set tax
     *
     * @param boolean $tax
     * @return Product
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax
     *
     * @return boolean 
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set imported
     *
     * @param boolean $imported
     * @return Product
     */
    public function setImported($imported)
    {
        $this->imported = $imported;

        return $this;
    }

    /**
     * Get imported
     *
     * @return boolean 
     */
    public function getImported()
    {
        return $this->imported;
    }

    /**
     * Get full price
     *
     * @return string 
     */
    public function getFullPrice()
    {
        if ($this->getImported() && $this->getTax()) {
            $fullPrice = $this->getPrice() + ceil((($this->getPrice() * (Product::BASIC_TAX + Product::IMPORT_TAX)) / 100) / 0.05) * 0.05;
        } elseif ($this->getImported() && !$this->getTax()) {
            $fullPrice = $this->getPrice() + ceil((($this->getPrice() * (Product::IMPORT_TAX)) / 100) / 0.05) * 0.05;
        } elseif (!$this->getImported() && $this->getTax()) {
            $fullPrice = $this->getPrice() + ceil((($this->getPrice() * (Product::BASIC_TAX)) / 100) / 0.05) * 0.05;
        } else {
            $fullPrice = $this->getPrice();
        }

        return $fullPrice;
    }
}
