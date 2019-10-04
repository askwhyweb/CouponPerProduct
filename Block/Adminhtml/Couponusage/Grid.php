<?php
namespace OrviSoft\CouponPerProduct\Block\Adminhtml\Couponusage;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \OrviSoft\CouponPerProduct\Model\couponusageFactory
     */
    protected $_couponusageFactory;

    /**
     * @var \OrviSoft\CouponPerProduct\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \OrviSoft\CouponPerProduct\Model\couponusageFactory $couponusageFactory
     * @param \OrviSoft\CouponPerProduct\Model\Status $status
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \OrviSoft\CouponPerProduct\Model\CouponusageFactory $CouponusageFactory,
        \OrviSoft\CouponPerProduct\Model\Status $status,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_couponusageFactory = $CouponusageFactory;
        $this->_status = $status;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
        $this->setVarNameFilter('post_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_couponusageFactory->create()->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );


		
				$this->addColumn(
					'order_id',
					[
						'header' => __('Order ID'),
						'index' => 'order_id',
					]
				);
				
				$this->addColumn(
					'order_total_before',
					[
						'header' => __('Order Total Before'),
						'index' => 'order_total_before',
					]
				);
				
				$this->addColumn(
					'order_discount',
					[
						'header' => __('Discount'),
						'index' => 'order_discount',
					]
				);
				
				$this->addColumn(
					'order_total',
					[
						'header' => __('Order Total'),
						'index' => 'order_total',
					]
                );
                
                $this->addColumn(
					'product_skus',
					[
						'header' => __('SKUs'),
						'index' => 'product_skus',
					]
				);
				
				$this->addColumn(
					'applied_coupon',
					[
						'header' => __('Applied Coupon'),
						'index' => 'applied_coupon',
					]
				);
				
				$this->addColumn(
					'used_at',
					[
						'header' => __('Used At'),
						'index' => 'used_at',
						'type'      => 'datetime',
					]
				);
					
					


		

		
		   $this->addExportType($this->getUrl('couponperproduct/*/exportCsv', ['_current' => true]),__('CSV'));
		   $this->addExportType($this->getUrl('couponperproduct/*/exportExcel', ['_current' => true]),__('Excel XML'));

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

	
    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('id');
        //$this->getMassactionBlock()->setTemplate('OrviSoft_CouponPerProduct::couponusage/grid/massaction_extended.phtml');
        $this->getMassactionBlock()->setFormFieldName('couponusage');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('couponperproduct/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );

        $statuses = $this->_status->getOptionArray();

        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('couponperproduct/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses
                    ]
                ]
            ]
        );


        return $this;
    }
		

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('couponperproduct/*/index', ['_current' => true]);
    }

    /**
     * @param \OrviSoft\CouponPerProduct\Model\couponusage|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
		return '#';
    }

	

}
