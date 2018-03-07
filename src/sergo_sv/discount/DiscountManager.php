<?php

namespace sergo_sv\discount;

/**
 * Class DiscountManager
 * @package sergo_sv\discount
 */
class DiscountManager
{
    /**
     * @var array
     */
    protected $discounts = [];

    /**
     * @var Order
     */
    protected $order;

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @param Discount $discount
     */
    public function addDiscount($discount)
    {
        $this->discounts[] = $discount;
    }

    /**
     * @return array
     */
    public function getDiscount()
    {
        return $this->discounts;
    }

    /**
     * @param Order $order
     * @return int|mixed
     */
    public function doCalculation(Order $order)
    {
        $sum = 0;
        /**
         * @var Discount $discount
         */
        foreach ($this->discounts as $discount) {
            $sum += $discount->doCalculation($order);
        }
        return $sum;
    }
}