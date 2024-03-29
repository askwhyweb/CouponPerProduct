<?php

namespace OrviSoft\CouponPerProduct\Block\Adminhtml\Coupons\Edit\Tab;

/**
 * Coupons edit form main tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \OrviSoft\CouponPerProduct\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \OrviSoft\CouponPerProduct\Model\Status $status,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \OrviSoft\CouponPerProduct\Model\BlogPosts */
        $model = $this->_coreRegistry->registry('coupons');

        $isElementDisabled = false;

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Coupon Information')]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }

		
        $fieldset->addField(
            'coupon_name',
            'text',
            [
                'name' => 'coupon_name',
                'label' => __('Promotion Name'),
                'title' => __('Promotion Name'),
				'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
					
        $fieldset->addField(
            'coupon_code',
            'text',
            [
                'name' => 'coupon_code',
                'label' => __('Coupon Code'),
                'title' => __('Coupon Code'),
				'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
					
        $fieldset->addField(
            'coupon_sku',
            'textarea',
            [
                'name' => 'coupon_sku',
                'label' => __('Product SKU\'s'),
                'title' => __('Product SKU\'s'),
				'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
					
        $fieldset->addField(
            'coupon_price',
            'text',
            [
                'name' => 'coupon_price',
                'label' => __('Discount Price'),
                'title' => __('Discount Price'),
				'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
										
        $fieldset->addField(
            'discount_type',
            'select',
            [
                'label' => __('Discount By'),
                'title' => __('Discount By'),
                'name' => 'discount_type',
				
                'options' => \OrviSoft\CouponPerProduct\Block\Adminhtml\Coupons\Grid::getOptionArray4(),
                'disabled' => $isElementDisabled
            ]
        );
										
						
        $fieldset->addField(
            'coupon_status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'coupon_status',
				
                'options' => \OrviSoft\CouponPerProduct\Block\Adminhtml\Coupons\Grid::getOptionArray5(),
                'disabled' => $isElementDisabled
            ]
        );
						
						

        if (!$model->getId()) {
            $model->setData('coupon_status', $isElementDisabled ? '0' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);
		
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Coupon Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Coupon Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
    
    public function getTargetOptionArray(){
    	return array(
    				'_self' => "Self",
					'_blank' => "New Page",
    				);
    }
}
