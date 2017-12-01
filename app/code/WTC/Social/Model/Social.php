<?php
namespace WTC\Social\Model;

class Social extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('WTC\Social\Model\ResourceModel\Social');
    }
}
?>