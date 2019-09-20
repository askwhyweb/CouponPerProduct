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
   /**
    * Custom constructor.
    * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    */
   public function __construct(
       \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
   ){
       $this->_priceCurrency = $priceCurrency;
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
           $baseDiscount = 10;
           $discount =  $this->_priceCurrency->convert($baseDiscount);
           $total->addTotalAmount('perproductdiscount', -$discount);
           $total->addBaseTotalAmount('perproductdiscount', -$baseDiscount);
           $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount);
           $quote->setPerproductDiscount(-$discount);
           $quote->setDiscountAmount($discount);
           
       return $this;
   }
}
