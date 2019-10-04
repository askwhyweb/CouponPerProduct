<?php

namespace OrviSoft\CouponPerProduct\Model\ResourceModel\Couponusage;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('OrviSoft\CouponPerProduct\Model\Couponusage', 'OrviSoft\CouponPerProduct\Model\ResourceModel\Couponusage');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>