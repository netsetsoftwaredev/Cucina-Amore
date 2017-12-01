<?php
namespace WTC\Instagram\Model\ResourceModel;

class Instagram extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('wtc_instagram_images', 'id');
    }
}
?>