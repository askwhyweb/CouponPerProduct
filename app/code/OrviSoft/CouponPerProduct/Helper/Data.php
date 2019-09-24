<?php

namespace OrviSoft\CouponPerProduct\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    protected $cart;
    protected $couponshelper;
    protected $Couponsusagehelper;
    protected $_checkoutSession;
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Checkout\Model\Cart $cart,
        \OrviSoft\CouponPerProduct\Helper\Couponshelper $_couponshelper,
        \OrviSoft\CouponPerProduct\Helper\Couponsusagehelper $Couponsusagehelper,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        parent::__construct($context);
        $this->cart = $cart;
        $this->couponshelper = $_couponshelper;
        $this->Couponsusagehelper = $Couponsusagehelper;
        $this->_checkoutSession = $checkoutSession;
    }

    public function getCartItems(){
        //$data = $this->cart->getQuote()->getItemsCollection(); //Returns a quote item collection with all items associated to the current quote.
        //$data = $this->cart->getItems(); //This is a shortcut for the method above, but if there is no quote it returns an empty array, so you cannot rely on getting a collection instance.
        //$data = $this->cart->getQuote()->getAllItems(); //Loads the item collection, then returns an array of all items which are not marked as deleted (i.e. have been removed in the current request).
        $data = $this->cart->getQuote()->getAllVisibleItems(); // Loads the item collection, then returns an array of all items which are not marked as deleted AND do not have a parent (i.e. you get items for bundled and configurable products but not their associated children). Each array item corresponds to a displayed row in the cart page.
        foreach($data as $item) {
            echo 'ID: '.$item->getProductId().'<br />';
            echo 'Name: '.$item->getName().'<br />';
            echo 'Sku: '.$item->getSku().'<br />';
            echo 'Quantity: '.$item->getQty().'<br />';
            echo 'Price: '.$item->getPrice().'<br />';
            echo "<hr />";            
        }
        return $data;
    }

    public function getCoupons(){
        return $this->couponshelper;
    }

    public function getCouponsHistory(){
        return $this->Couponsusagehelper;
    }

    public function getCouponCode(){
        return $couponCode = $this->_checkoutSession->getPerProductCouponCode();
    }

    public function getSessionValues(){
        $code = $this->_checkoutSession->getPerProductCouponCode();
        $skus = $this->_checkoutSession->getPerProductSkus();
        $discount_type = $this->_checkoutSession->getPerProductDiscountType();
        $discount_amount = $this->_checkoutSession->getPerProductDiscountAmount();
        return ['code' => $code, 'discount_type'=> $discount_type, 'discount_amount' => $discount_amount];
    }

    public function validateCoupon($coupon){
        if(!strlen(trim($coupon))){
            return false;
        }
        $collection = $this->getCoupons()->getCollection();
        $collection->addFieldToFilter('coupon_status', ['eq' => 0]); // Status is set to Active.
        $collection->addFieldToFilter('coupon_code', ['eq' => $coupon]); //Coupon code


        if($collection->count() == 0){
            return false;
        }
        $quote = $this->cart->getQuote();
        $furtherstop = false;
        $discountAmount = 0;
        $applycoupon = false;
        foreach($collection as $key => $_rule){
            $data = $_rule->getData();
            $skus = $_rule->getCouponSku();
            $sku_array = explode(',', $skus);
            $percent = false;
            $percent_price = 0;
            $coupon_price =  $_rule->getCouponPrice();
            if($_rule->getDiscountType()){ // 1 for percentage and 0 for by price.
				$percent = true;
			}
            foreach($quote->getAllItems() as $item){
				if (in_array($item->getSku(), $sku_array) && $furtherstop == false) {
					$applycoupon = true;

					$applied_skus[] = $item->getSku();

					if($_rule->getDiscountType()){ // discount type percentage.
						$percent_price =  $item->getPrice() * $coupon_price/100;
						$discountAmount = $discountAmount + $percent_price;
					}else{ // discount type fixed price.
						$discountAmount = $discountAmount + $coupon_price;
						$furtherstop = true;
					}

				}
			
			}
        }
        if(!$applycoupon){
            return false;
        }
        return ['Code'=>$coupon, 'Discount_Type'=> ($percent ? 'Percentage' : 'Fixed'), 'DiscountAmount' => $discountAmount];
    }
}
