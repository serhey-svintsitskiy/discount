<?php
set_time_limit(960);
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../vendor/autoload.php';

$testConfig = include(__DIR__.'/../config/test.php');
$productsMap = \sergo_sv\discount\ConfigLoader::loadProducts($testConfig['products']);
$discountRules = \sergo_sv\discount\ConfigLoader::loadDiscounts($productsMap, $testConfig['discounts']);

//Create order
$testOrder = new sergo_sv\discount\Order();
foreach($productsMap as $product){
    $testOrder->addProduct($product);
}
//Add discount
$testDiscountManager = new sergo_sv\discount\DiscountManager();
foreach($discountRules as $discountRule){
    $testDiscountManager->addDiscount($discountRule);
}
//Do calculation
$testOrder->setDiscountManager($testDiscountManager);
$testAmount = $testOrder->getTotalPrice();

print_r([$testAmount, $testOrder]); die;
//must be
