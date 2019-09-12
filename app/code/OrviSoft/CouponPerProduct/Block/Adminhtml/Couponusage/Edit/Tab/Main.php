<?php

namespace OrviSoft\CouponPerProduct\Block\Adminhtml\Couponusage\Edit\Tab;

/**
 * Couponusage edit form main tab
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
        $model = $this->_coreRegistry->registry('couponusage');

        $isElementDisabled = false;

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Item Information')]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }

		
        $fieldset->addField(
            'order_id',
            'text',
            [
                'name' => 'order_id',
                'label' => __('Order ID'),
                'title' => __('Order ID'),
				
                'disabled' => $isElementDisabled
            ]
        );
					
        $fieldset->addField(
            'order_total_before',
            'text',
            [
                'name' => 'order_total_before',
                'label' => __('Order Total Before'),
                'title' => __('Order Total Before'),
				
                'disabled' => $isElementDisabled
            ]
        );
					
        $fieldset->addField(
            'order_discount',
            'text',
            [
                'name' => 'order_discount',
                'label' => __('Discount'),
                'title' => __('Discount'),
				
                'disabled' => $isElementDisabled
            ]
        );
					
        $fieldset->addField(
            'order_total',
            'text',
            [
                'name' => 'order_total',
                'label' => __('Order Total'),
                'title' => __('Order Total'),
				
                'disabled' => $isElementDisabled
            ]
        );
					
        $fieldset->addField(
            'applied_coupon',
            'text',
            [
                'name' => 'applied_coupon',
                'label' => __('Applied Coupon'),
                'title' => __('Applied Coupon'),
				
                'disabled' => $isElementDisabled
            ]
        );
					
        $fieldset->addField(
            'product_skus',
            'textarea',
            [
                'name' => 'product_skus',
                'label' => __('Product SKUs'),
                'title' => __('Product SKUs'),
				
                'disabled' => $isElementDisabled
            ]
        );
					

        $dateFormat = $this->_localeDate->getDateFormat(
            \IntlDateFormatter::MEDIUM
        );
        $timeFormat = $this->_localeDate->getTimeFormat(
            \IntlDateFormatter::MEDIUM
        );

        $fieldset->addField(
            'used_at',
            'date',
            [
                'name' => 'used_at',
                'label' => __('Used At'),
                'title' => __('Used At'),
                    'date_format' => $dateFormat,
                    //'time_format' => $timeFormat,
				
                'disabled' => $isElementDisabled
            ]
        );
						
						
						

        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
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
        return __('Item Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Item Information');
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
