<?php
/**
 * @author Cadence Labs <info@cadence-labs.com>
 */
namespace Cadence\Criteo\Observer;

use Magento\Framework\Event\ObserverInterface;

class CatalogBlockProductListObserver implements ObserverInterface {

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * CatalogBlockProductListObserver constructor.
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(\Magento\Framework\Registry $registry) {
        $this->_registry = $registry;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer) {
        if(!$this->_registry->registry('criteo_catalog_block_product_list_collection')) {
            $collection = $observer->getData('collection');
            $this->_registry->register('criteo_catalog_block_product_list_collection', $collection);
        }
    }
}
