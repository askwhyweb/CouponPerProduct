<?php

namespace OrviSoft\CouponPerProduct\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Couponshelper extends AbstractHelper
{
    protected $_couponsFactory;
    
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \OrviSoft\CouponPerProduct\Model\CouponsFactory $CouponsFactory
    ) {
        parent::__construct($context);
        $this->_couponsFactory = $CouponsFactory;
    }

    function getCollection(){
        return $this->_couponsFactory->create()->getCollection();
    }

    function getCouponsFactory(){
        return $this->_couponsFactory;
    }

}
