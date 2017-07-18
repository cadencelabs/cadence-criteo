<?php
/**
 * @author Cadence Labs <info@cadence-labs.com>
 */
namespace Cadence\Criteo\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {

    /**
     * @return string
     */
    public function getAccountId() {
        return $this->scopeConfig->getValue('criteo/tags/account_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
