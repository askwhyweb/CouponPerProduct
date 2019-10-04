<?php
namespace OrviSoft\CouponPerProduct\Block\Adminhtml\Couponusage\Edit;

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
        $this->setId('couponusage_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Couponusage Information'));
    }
}