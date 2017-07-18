<?php
/**
 * @author Cadence Labs <info@cadence-labs.com>
 */
namespace Cadence\Criteo\Block;

class Cart extends Base
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * Cart constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Cadence\Criteo\Helper\Data $helper
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Cadence\Criteo\Helper\Data $helper,
        \Magento\Checkout\Model\Session $checkoutSession,
        array $data
    )
    {
        $this->_checkoutSession = $checkoutSession;
        parent::__construct($context, $helper, $data);
    }

    public function getItemsJson()
    {
        $items = $this->_checkoutSession->getQuote()->getAllVisibleItems();
        $arr = array();
        foreach ($items as $item) {
            $qty = max(round($item->getQty()), 1);
            $realPrice = round($item->getPrice() - $item->getDiscountAmount(), 2);
            $arr[] = array(
                'id' => $item->getSku(),
                'price' => $realPrice,
                'quantity' => $qty
            );
        }
        return json_encode($arr);
    }
}
