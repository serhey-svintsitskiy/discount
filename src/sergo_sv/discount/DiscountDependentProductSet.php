<?php

namespace sergo_sv\discount;

/**
 * Class DiscountDependentProductSet
 * @package sergo_sv\discount
 */
class DiscountDependentProductSet extends Discount
{
    /**
     * @var null
     */
    protected $main_product = null;
    /**
     * @var array
     */
    protected $dependent_products = [];

    /**
     * @param Product $product
     */
    public function setMainProduct(Product $product)
    {
        $this->main_product = $product;
    }

    /**
     * @param Product $product
     */
    public function setDependentProduct(Product $product)
    {
        $this->dependent_products[] = $product;
    }

    /**
     * @param Order $order
     * @return float|int|mixed
     */
    public function doCalculation(Order $order)
    {
        $sum = 0;
        $main_product = false;
        //test main main product and set dependent products
        if (!is_object($this->main_product) || count($this->dependent_products) == 0) {
            return $sum;
        }
        $orderItems = $order->orderItems;

        //find main product into order
        foreach ($orderItems as $orderItem) {
            if ($orderItem->product == $this->main_product) {
                $main_product = true;
            }
        }
        reset($orderItems);
        if (!$main_product) {
            return $sum;
        }

        //find dependent products
        /**
         * @var OrderItem $orderItem
         */
        foreach ($orderItems as &$orderItem) {
            if (in_array($orderItem->product, $this->dependent_products) && $orderItem->isNotDiscounted()) {
                $sum += $orderItem->getPrice();
                $orderItem->isDiscounted = true;
                $orderItem->discountInfo[] = ['dependent_product_set', $this->getDiscount()];
            }
        }
        return $sum * $this->getDiscount();
    }
}