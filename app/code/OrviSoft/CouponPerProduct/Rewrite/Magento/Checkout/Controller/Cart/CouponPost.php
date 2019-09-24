<?php

namespace OrviSoft\CouponPerProduct\Rewrite\Magento\Checkout\Controller\Cart;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;


class CouponPost extends \Magento\Checkout\Controller\Cart\CouponPost
{

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Magento\SalesRule\Model\CouponFactory $couponFactory
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @codeCoverageIgnore
     */
    protected $checkoutSession;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\SalesRule\Model\CouponFactory $couponFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
    ) {
        parent::__construct(
            $context,
            $scopeConfig,
            $checkoutSession,
            $storeManager,
            $formKeyValidator,
            $cart,
            $couponFactory,
            $quoteRepository
        );
        $this->couponFactory = $couponFactory;
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * Initialize coupon
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $escaper = $this->_objectManager->get(\Magento\Framework\Escaper::class);
        $oscp = $this->_objectManager->create('OrviSoft\CouponPerProduct\Helper\Data');
        $couponCode = $this->getRequest()->getParam('remove') == 1
            ? ''
            : trim($this->getRequest()->getParam('coupon_code'));
        //$cartQuote = $this->cart->getQuote();
        //$cartQuote->setCouponCode($couponCode)->collectTotals();
        //$this->quoteRepository->save($cartQuote);
        //$this->_checkoutSession->getQuote()->setCouponCode($couponCode)->save();
        $validateCoupon = $oscp->validateCoupon($couponCode);
        if(strlen($couponCode) && is_array($validateCoupon)){
            $this->messageManager->addSuccessMessage(
                            __(
                                'You used coupon code "%1".',
                                $escaper->escapeHtml($couponCode)
                            )
                        );
        }
        if($this->getRequest()->getParam('remove') == 1){
            $this->messageManager->addSuccessMessage(
                            __(
                                'You canceled the coupon code.'
                            )
                        );
        }
        if(!is_array($validateCoupon) && $validateCoupon == false && $this->getRequest()->getParam('remove') != 1){
            return parent::execute();
        }

        $this->_checkoutSession->setPerProductCouponCode($validateCoupon['Code']);
        $this->_checkoutSession->setPerProductDiscountType($validateCoupon['Discount_Type']);
        $this->_checkoutSession->setPerProductDiscountAmount($validateCoupon['DiscountAmount']);
        return $this->_goBack();

    }
}
