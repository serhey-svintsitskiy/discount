<?php

namespace sergo_sv\discount;

/**
 * Class Product
 * @package sergo_sv\discount
 */
class Product
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var float
     */
    protected $price;

    /**
     * Product constructor.
     * @param string $name
     * @param float $price
     */
    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
}
