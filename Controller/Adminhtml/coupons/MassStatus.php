<?php
namespace OrviSoft\CouponPerProduct\Controller\Adminhtml\coupons;

use Magento\Backend\App\Action;

class MassStatus extends \Magento\Backend\App\Action
{
    /**
     * Update coupon(s) status action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $itemIds = $this->getRequest()->getParam('coupons');
        if (!is_array($itemIds) || empty($itemIds)) {
            $this->messageManager->addError(__('Please select item(s).'));
        } else {
            try {
                $status = (int) $this->getRequest()->getParam('coupon_status');
                foreach ($itemIds as $postId) {
                    $post = $this->_objectManager->get('OrviSoft\CouponPerProduct\Model\Coupons')->load($postId);
                    $post->setCouponStatus($status)->save();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 Coupon(s) have been updated.', count($itemIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        return $this->resultRedirectFactory->create()->setPath('couponperproduct/*/index');
    }

}