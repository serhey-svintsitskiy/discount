<?php

namespace sergo_sv\discount;

/**
 * Class Order
 * @package sergo_sv\discount
 */
class Order
{
    /**
     * @var OrderItem[]
     */
    public $orderItems = [];

    /**
     * @var DiscountManager
     */
    protected $discountManager;

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $this->orderItems[] = new OrderItem($product);
    }

    /**
     * @return OrderItem[]
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return count($this->orderItems);
    }

    /**
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->doCalculation();
    }

    /**
     * @param DiscountManager $discountManager
     */
    public function setDiscountManager(DiscountManager $discountManager)
    {
        $this->discountManager = $discountManager;
    }

    /**
     * @return float
     */
    public function doCalculation()
    {
        $sum = $this->discountManager->doCalculation($this);
        $sum += $this->doCalculateWithoutDiscount();
        return $sum;
    }

    /**
     * @return float
     */
    protected function doCalculateWithoutDiscount()
    {
        $sum = 0;
        foreach ($this->getOrderItems() as $orderItem) {
            if ($orderItem->isNotDiscounted()) {
                $sum += $orderItem->getPrice();
            }
        }
        return $sum;
    }

}
