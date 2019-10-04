<?php
namespace OrviSoft\CouponPerProduct\Rewrite\SalesRule\Model;

use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Item\AbstractItem;
use Magento\Quote\Model\Cart\Totals;

class Validator extends \Magento\SalesRule\Model\Validator
{
    /**
     * Quote item discount calculation process
     *
     * @param AbstractItem $item
     * @return $this
     */
    public function process(AbstractItem $item)
    {
		$_totals = new Totals();
		$_totals>setCouponCode('baby-123');
        $item->setDiscountAmount(51);
        $item->setBaseDiscountAmount(0);
        $item->setDiscountPercent(0);
		$_product = $item->getProduct();
		//echo $_product->getSku();
		return $this;

        $itemPrice = $this->getItemPrice($item);
        if ($itemPrice < 0) {
            return $this;
        }

        $appliedRuleIds = $this->rulesApplier->applyRules(
            $item,
            $this->_getRules($item->getAddress()),
            $this->_skipActionsValidation,
            $this->getCouponCode()
        );
        $this->rulesApplier->setAppliedRuleIds($item, $appliedRuleIds);

        return $this;
    }
}
