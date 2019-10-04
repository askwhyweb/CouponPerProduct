<?php
namespace OrviSoft\CouponPerProduct\Block\Adminhtml\Coupons;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \OrviSoft\CouponPerProduct\Model\couponsFactory
     */
    protected $_couponsFactory;

    /**
     * @var \OrviSoft\CouponPerProduct\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \OrviSoft\CouponPerProduct\Model\couponsFactory $couponsFactory
     * @param \OrviSoft\CouponPerProduct\Model\Status $status
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \OrviSoft\CouponPerProduct\Model\CouponsFactory $CouponsFactory,
        \OrviSoft\CouponPerProduct\Model\Status $status,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_couponsFactory = $CouponsFactory;
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
        $collection = $this->_couponsFactory->create()->getCollection();
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
					'coupon_name',
					[
						'header' => __('Promotion Name'),
						'index' => 'coupon_name',
					]
				);
				
				$this->addColumn(
					'coupon_code',
					[
						'header' => __('Coupon Code'),
						'index' => 'coupon_code',
					]
				);
				
				$this->addColumn(
					'coupon_sku',
					[
						'header' => __('SKUs'),
						'index' => 'coupon_sku',
					]
				);
				
				
				
						$this->addColumn(
							'discount_type',
							[
								'header' => __('Discount By'),
								'index' => 'discount_type',
								'type' => 'options',
								'options' => \OrviSoft\CouponPerProduct\Block\Adminhtml\Coupons\Grid::getOptionArray4()
							]
						);
				$this->addColumn(
					'coupon_price',
					[
						'header' => __('Discount'),
						'index' => 'coupon_price',
					]
				);
						$this->addColumn(
							'coupon_status',
							[
								'header' => __('Status'),
								'index' => 'coupon_status',
								'type' => 'options',
								'options' => \OrviSoft\CouponPerProduct\Block\Adminhtml\Coupons\Grid::getOptionArray5()
							]
						);
						
						


		
        //$this->addColumn(
            //'edit',
            //[
                //'header' => __('Edit'),
                //'type' => 'action',
                //'getter' => 'getId',
                //'actions' => [
                    //[
                        //'caption' => __('Edit'),
                        //'url' => [
                            //'base' => '*/*/edit'
                        //],
                        //'field' => 'id'
                    //]
                //],
                //'filter' => false,
                //'sortable' => false,
                //'index' => 'stores',
                //'header_css_class' => 'col-action',
                //'column_css_class' => 'col-action'
            //]
        //);
		

		
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
        //$this->getMassactionBlock()->setTemplate('OrviSoft_CouponPerProduct::coupons/grid/massaction_extended.phtml');
        $this->getMassactionBlock()->setFormFieldName('coupons');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('couponperproduct/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );

        //$statuses = $this->_status->getOptionArray();
        $statuses = \OrviSoft\CouponPerProduct\Block\Adminhtml\Coupons\Grid::getOptionArray5();

        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('couponperproduct/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'coupon_status',
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
     * @param \OrviSoft\CouponPerProduct\Model\coupons|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
		
        return $this->getUrl(
            'couponperproduct/*/edit',
            ['id' => $row->getId()]
        );
		
    }

	
		static public function getOptionArray4()
		{
            $data_array=array(); 
			$data_array[0]='Price';
			$data_array[1]='Percentage';
            return($data_array);
		}
		static public function getValueArray4()
		{
            $data_array=array();
			foreach(\OrviSoft\CouponPerProduct\Block\Adminhtml\Coupons\Grid::getOptionArray4() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray5()
		{
            $data_array=array(); 
			$data_array[0]='Active';
			$data_array[1]='Inactive';
            return($data_array);
		}
		static public function getValueArray5()
		{
            $data_array=array();
			foreach(\OrviSoft\CouponPerProduct\Block\Adminhtml\Coupons\Grid::getOptionArray5() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}