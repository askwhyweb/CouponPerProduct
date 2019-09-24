<?php

namespace OrviSoft\CouponPerProduct\Model;

class DiscountpercouponManagement implements \OrviSoft\CouponPerProduct\Api\DiscountpercouponManagementInterface
{
    
    public function getDiscountpercoupon($param)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $helper = $objectManager->create('OrviSoft\CouponPerProduct\Helper\Data');
        $coupon = $helper->getCouponCode();
        if(!strlen($coupon)){
            return ['discount_name' => 'Discount', 'discount_price' => 0, 'show'=> false];
        }
        $sessionValues = $helper->getSessionValues();
        
        $title = sprintf(_("Discount (%s)"), $coupon);
        return ['discount_name' => $title, 'discount_price' => $sessionValues['discount_amount'], 'show' => true];
    }
}
