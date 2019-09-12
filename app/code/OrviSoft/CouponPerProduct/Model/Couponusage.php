<?php
namespace OrviSoft\CouponPerProduct\Model;

class Couponusage extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('OrviSoft\CouponPerProduct\Model\ResourceModel\Couponusage');
    }
}
?>