<?php
/**
 * @category Mageants ExtraFee
 * @package Mageants_ExtraFee
 * @copyright Copyright (c) 2017 Mageants
 * @author Mageants Team <support@mageants.com>
 */
namespace Rocktechnolabs\CLP\Model\Source;
use Magento\Framework\App\Filesystem\DirectoryList;
/**
 * Return Extra fee list
 */
class NitritionIcon implements \Magento\Framework\Option\ArrayInterface
{
    protected $_storeManager;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
    }

    /**
     * @return Array
     */
    public function toOptionArray()
    {
        $options=array();
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $filesystem = $objectManager->get('Magento\Framework\Filesystem');
        $directory = $filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $imageDir = $directory->getAbsolutePath() . DIRECTORY_SEPARATOR . 'Rocktechnolabs' . DIRECTORY_SEPARATOR . 'IteritionIcon';
        $directoryIterator = new \RecursiveDirectoryIterator($imageDir);

        foreach (new \RecursiveIteratorIterator($directoryIterator) as $file) {
            $filename=$file->getFilename();
            $options[]=array('value'=>$filename,'label'=>strtok($filename, '.'));
        }

        return $options;
    }
}
