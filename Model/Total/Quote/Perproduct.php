<?php
namespace OrviSoft\CouponPerProduct\Model\Total\Quote;
/**
* Class Perproduct
* @package OrviSoft\CouponPerProduct\Model\Total\Quote
*/
class Perproduct extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
   /**
    * @var \Magento\Framework\Pricing\PriceCurrencyInterface
    */
   protected $_priceCurrency;
   protected $_helper;
   /**
    * Custom constructor.
    * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    */
   public function __construct(
       \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
       \OrviSoft\CouponPerProduct\Helper\Data $helper
   ){
       $this->_priceCurrency = $priceCurrency;
       $this->_helper = $helper;
   }
   /**
    * @param \Magento\Quote\Model\Quote $quote
    * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
    * @param \Magento\Quote\Model\Quote\Address\Total $total
    * @return $this|bool
    */
   public function collect(
       \Magento\Quote\Model\Quote $quote,
       \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
       \Magento\Quote\Model\Quote\Address\Total $total
   )
   {
       parent::collect($quote, $shippingAssignment, $total);
       $discount = $this->_helper->getSessionValues();
       $applyDiscount = false;
       if(is_array($discount)){
            $coupon = $this->_helper->getCouponCode();
            $validated = $this->_helper->validateCoupon($coupon);
            if(is_array($validated)){
                $applyDiscount = true;
            }
       }
       if($applyDiscount){
           $baseDiscount = $validated['DiscountAmount'];
           $discount =  $this->_priceCurrency->convert($baseDiscount);
           $total->addTotalAmount('perproductdiscount', -$discount);
           $total->addBaseTotalAmount('perproductdiscount', -$baseDiscount);
           $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount);
           $total->setDiscountAmount($discount);
           $quote->setPerproductDiscount(-$discount);
           $quote->setDiscountAmount($discount);
       }
       return $this;
   }
}
