<?php
/**
 * @author Cadence Labs <info@cadence-labs.com>
 */
namespace Cadence\Criteo\Block;

class Checkoutsuccess extends Base
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Cadence\Criteo\Helper\Data $helper,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        array $data
    ) {
        $this->_checkoutSession = $checkoutSession;
        $this->_orderFactory = $orderFactory;
        parent::__construct($context, $helper, $data);
    }

    /**
     * @param $orderId
     * @return \Magento\Sales\Model\Order
     */
    protected function _getOrderById($orderId)
    {
        return $this->_orderFactory->create()->load($orderId);
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        $lastOrderId = $this->_checkoutSession->getLastOrderId();
        $order = $this->_getOrderById($lastOrderId);
        return $order->getIncrementId();
    }

    /**
     * @return string
     */
    public function getCustomerEmail()
    {
        $lastOrderId = $this->_checkoutSession->getLastOrderId();
        $order = $this->_getOrderById($lastOrderId);
        return $order->getCustomerEmail();
    }

    /**
     * @return string
     */
    public function getItemsJson()
    {
        $arr = array();
        $lastOrderId = $this->_checkoutSession->getLastOrderId();
        $order = $this->_getOrderById($lastOrderId);
        if ($order->getId()) {
            foreach ($order->getAllVisibleItems() as $item) {
                $qty = max(round($item->getQtyOrdered()), 1);
                $realPrice = round($item->getPrice() - $item->getDiscountAmount(), 2);
                $arr[] = array(
                    'id' => $item->getSku(),
                    'price' => $realPrice,
                    'quantity' => $qty
                );
            }
        }
        return json_encode($arr);
    }
}
