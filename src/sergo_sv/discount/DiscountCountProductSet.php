<?php

namespace sergo_sv\discount;

/**
 * Class DiscountCountProductSet
 * @package sergo_sv\discount
 */
class DiscountCountProductSet extends Discount
{
    /**
     * @var array
     */
    protected $discountRule = [];
    /**
     * @var array
     */
    protected $exceptedProducts = [];

    /**
     * @param Product $exceptedProduct
     */
    public function addExpectedProduct(Product $exceptedProduct)
    {
        $this->exceptedProducts[] = $exceptedProduct;
    }


    /**
     * @param int $count
     * @param float $discount
     */
    public function addDiscountRule($count, $discount)
    {
        $this->discountRule[$count] = 1 - $discount / 100;
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function isNotExceptedProduct($product)
    {
        return !in_array($product, $this->exceptedProducts);
    }

    /**
     * @param Order $order
     * @return int|float
     */
    public function doCalculation(Order $order)
    {
        $sum = 0;
        $cnt = 0;
        foreach ($order->getOrderItems() as $orderItem) {
            if ($this->isNotExceptedProduct($orderItem->product) && $orderItem->isNotDiscounted()) {
                $sum += $orderItem->getPrice();
                $orderItem->isDiscounted = true;
                $cnt++;
                $orderItem->discountInfo[] = ['count_product_set', $this->getDiscount(), $cnt];
            }
        }

        if (array_key_exists($cnt, $this->discountRule)) {
            $sum *= $this->discountRule[$cnt];
        }
        return $sum;
    }
}