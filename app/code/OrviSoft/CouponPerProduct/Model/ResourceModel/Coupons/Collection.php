<?php

namespace OrviSoft\CouponPerProduct\Model\ResourceModel\Coupons;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('OrviSoft\CouponPerProduct\Model\Coupons', 'OrviSoft\CouponPerProduct\Model\ResourceModel\Coupons');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>