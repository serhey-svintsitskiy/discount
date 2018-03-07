<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 3/6/18
 * Time: 1:10 PM
 */

namespace sergo_sv\discount;

/**
 * Class OrderItem
 * @package sergo_sv\discount
 */
class OrderItem
{
    /**
     * @var Product;
     */
    public $product;

    /**
     * @var bool
     */
    public $isDiscounted = false;

    /**
     * @var array
     */
    public $discountInfo = [];

    /**
     * OrderItem constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return bool
     */
    public function isNotDiscounted()
    {
        return !$this->isDiscounted;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->product->getPrice();
    }
}