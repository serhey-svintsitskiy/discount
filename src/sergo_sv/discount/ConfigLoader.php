<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 3/6/18
 * Time: 2:07 PM
 */

namespace sergo_sv\discount;

/**
 * Class ConfigLoader
 * @package sergo_sv\discount
 */
class ConfigLoader
{
    /**
     * @param array $productsConfig
     * @return array
     */
    public static function loadProducts($productsConfig = [])
    {
        $productsMap = [];
        foreach ($productsConfig as $productConfig) {
            $productId = $productConfig[0];
            $productsMap[$productId] = new Product($productConfig[0], $productConfig[1]);
        }
        return $productsMap;
    }

    /**
     * @param array $productsMap
     * @param array $discountsConfig
     * @return array
     */
    public static function loadDiscounts($productsMap, $discountsConfig = [])
    {
        $discounts = [];
        foreach ($discountsConfig as $discountType => $discountsConfigType) {
            switch ($discountType) {
                case 'product_set':
                    foreach ($discountsConfigType as $discountConfig) {
                        $discount = new DiscountProductSet();
                        $prodSet = [];
                        foreach ($discountConfig[0] as $prodId) {
                            $prodSet = $productsMap[$prodId];
                        }
                        $discount->setProductSet($prodSet);
                        $discount->setDiscount($discountConfig[1]);
                        $discounts[] = $discount;
                    }
                    break;
                case 'dependent_product_set':
                    foreach ($discountsConfigType as $discountConfig) {
                        //Discount by dependent
                        $discount = new DiscountDependentProductSet();
                        $discount->setMainProduct($productsMap[$discountConfig[0]]);
                        foreach ($discountConfig[1] as $depProductId) {
                            $discount->setDependentProduct($productsMap[$depProductId]);
                        }
                        $discount->setDiscount($discountConfig[2]);
                        $discounts[] = $discount;
                    }
                    break;
                case 'count_product_set':
                    foreach ($discountsConfigType as $discountConfig) {
                        //Discount by count
                        $discount = new DiscountCountProductSet();
                        foreach ($discountConfig[0] as $discountRule) {
                            $discount->addDiscountRule($discountRule[0], $discountRule[1]);
                        }
                        foreach ($discountConfig[1] as $productId) {
                            $discount->addExpectedProduct($productsMap[$productId]);
                        }
                        $discounts[] = $discount;
                    }
                    break;
            }
        }
        return $discounts;
    }
}