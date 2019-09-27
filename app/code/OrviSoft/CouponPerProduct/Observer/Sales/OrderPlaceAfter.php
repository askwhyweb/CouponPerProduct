<?php

namespace OrviSoft\CouponPerProduct\Observer\Sales;

class OrderPlaceAfter implements \Magento\Framework\Event\ObserverInterface
{
    protected $_helper;
    protected $couponusage;
    public function __construct(
        \OrviSoft\CouponPerProduct\Helper\Data $helper,
        \OrviSoft\CouponPerProduct\Model\Couponusage $couponusage
    ){
        $this->_helper = $helper;
        $this->couponusage = $couponusage;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $order = $observer->getEvent()->getOrder();
        $order_id = $order->getId();
        $sessionValues = $this->_helper->getSessionValues();
        //print_r($sessionValues);
        $coupon_data = array(
				//'order_id' => $order->getId(),
				'order_id' => $order->getIncrementId(),
				'order_total' => $order->getGrandTotal(),
				'order_total_before' => $order->getSubtotal(),
				'order_discount' => $order->getDiscountAmount(),
				'applied_coupon' => $sessionValues['code'],
				'product_skus' => $sessionValues['skus'],
				'used_at' => date('Y-m-d H:i:s')
            );
        //print_r($coupon_data);
        $this->_helper->unsetSessionValues(); // unset session
        $this->couponusage->setData($coupon_data)->save();
        return $this;
    }
}
