<?php
namespace OrviSoft\CouponPerProduct\Model\ResourceModel;

class Coupons extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('coupon_per_product', 'id');
    }
}
?>