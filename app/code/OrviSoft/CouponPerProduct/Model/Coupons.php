<?php
namespace OrviSoft\CouponPerProduct\Model;

class Coupons extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('OrviSoft\CouponPerProduct\Model\ResourceModel\Coupons');
    }
}
?>