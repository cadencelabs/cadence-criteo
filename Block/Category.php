<?php
/**
 * @author Cadence Labs <info@cadence-labs.com>
 */
namespace Cadence\Criteo\Block;

class Category extends Base
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * Category constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Cadence\Criteo\Helper\Data $helper
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Cadence\Criteo\Helper\Data $helper,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_registry = $registry;
        parent::__construct($context, $helper, $data);
    }

    public function getItemsJson()
    {
        $items = $this->_registry->registry('catalog_block_product_list_collection');
        $arr = array();
        if ($items) {
            $i = 0;
            foreach ($items as $item) {
                if (++$i > 3) {
                    break;
                }
                $arr[] = $item->getSku();
            }
        }
        return json_encode($arr);
    }
}
