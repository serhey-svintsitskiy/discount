<?php

namespace sergo_sv\discount;

/**
 * Class DiscountProductSet
 * @package sergo_sv\discount
 */
class DiscountProductSet extends Discount
{
    /**
     * @var Product[]
     */
    protected $productsSet = [];

    /**
     * @param Product[] $productsSet
     */
    public function setProductSet($productsSet)
    {
        $this->productsSet = $productsSet;
    }

    /**
     * @return Product[]
     */
    public function getProductSet()
    {
        return $this->productsSet;
    }

    /**
     * @param Order $order
     * @return float|int|mixed
     */
    public function doCalculation(Order $order)
    {
        $sum = 0;
        $productsOrder = &$order->orderItems;
        //For each pair go recursively
        $sum = $this->doRecursive($productsOrder, $sum);
        return $sum;
    }

    /**
     * @param OrderItem[] $productsOrder
     * @param $sum
     * @return float|int
     */
    private function doRecursive(&$productsOrder, $sum)
    {
        /**
         * @var OrderItem[]
         */
        $discountProducts = [];
        foreach ($this->productsSet as $productSet) {
            foreach ($productsOrder as &$orderItem) {
                if ($orderItem->product === $productSet && $orderItem->isNotDiscounted()) {
                    $discountProducts[] = &$orderItem;
                    break;
                }
            }
        }

        if (count($discountProducts) == count($this->productsSet)) {
            /**
             * @var OrderItem $discountProduct
             */
            foreach ($discountProducts as &$discountProduct) {
                $discountProduct->isDiscounted = true;
                $sum += $discountProduct->getPrice();
                $discountProduct->discountInfo[] = ['count_product_set', $this->getDiscount()];
            }
            return $this->doRecursive($productsOrder, $sum);
        }
        return $sum * $this->getDiscount();
    }
}