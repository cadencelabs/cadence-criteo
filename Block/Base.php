<?php
/**
 * @author Cadence Labs <info@cadence-labs.com>
 */
namespace Cadence\Criteo\Block;

class Base extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Cadence\Criteo\Helper\Data
     */
    protected $_helper;

    /**
     * Base constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Cadence\Criteo\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Cadence\Criteo\Helper\Data $helper,
        array $data = []
    )
    {
        $this->_helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->_helper->getAccountId();
    }

    /**
     * @return string
     */
    public function getCustomerEmail()
    {
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $om->create('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn()) {
            return trim(strtolower($customerSession->getCustomer()->getEmail()));
        }
        return '';
    }
}
