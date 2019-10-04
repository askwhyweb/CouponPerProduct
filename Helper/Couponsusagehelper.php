<?php

namespace OrviSoft\CouponPerProduct\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Couponsusagehelper extends AbstractHelper
{
    protected $_couponusageFactory;
    
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \OrviSoft\CouponPerProduct\Model\CouponusageFactory $CouponusageFactory
    ) {
        parent::__construct($context);
        $this->_couponusageFactory = $CouponusageFactory;
    }

    function getCollection(){
        return $this->_couponusageFactory->create()->getCollection();
    }

    function getCouponsHistoryFactory(){
        return $this->_couponusageFactory;
    }

}
