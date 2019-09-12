<?php
namespace OrviSoft\CouponPerProduct\Block\Adminhtml\Coupons\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('coupons_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Coupons Information'));
    }
}