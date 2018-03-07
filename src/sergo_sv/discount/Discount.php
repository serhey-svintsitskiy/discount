<?php

namespace sergo_sv\discount;

/**
 * Class Discount
 * @package sergo_sv\discount
 */
abstract class Discount
{
    /**
     * @var float
     */
    protected $discount = 1;

    /**
     * @param Order $order
     * @return mixed
     */
    abstract function doCalculation(Order $order);

    /**
     * @param $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = 1 - $discount / 100;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }
}
