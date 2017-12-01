<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Geoip
 */


namespace Amasty\Geoip\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    CONST BLOCK_FILE = 'amgeoip/general/block_file_url';
    CONST LOCATION_FILE = 'amgeoip/general/location_file_url';

    public $_geoipRequiredFiles = array(
        'block' => 'amasty_geiop_block.sql',
        'location' => 'amasty_geiop_location.sql'
    );

    protected $_geoipCsvFiles = array(
        'block' => 'GeoLite2-City-Blocks-IPv4.csv',
        'location' => 'GeoLite2-City-Locations-en.csv'
    );

    public $_geoipIgnoredLines = array(
        'block' => 2,
        'location' => 2
    );

    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $directoryList;

    /**
     * Resource model of config data
     *
     * @var \Magento\Framework\App\Config\ConfigResource\ConfigInterface
     */
    protected $_resource;

    /** @var \Magento\Framework\App\Cache\StateInterface $_state */
    protected $_state;

    /** @var \Magento\Framework\App\Cache\TypeListInterface $_cacheTypeList */
    protected $_cacheTypeList;

    protected $_cacheEnabled;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    private $fileDriver;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directoryList
     * @param \Magento\Framework\App\Config\ConfigResource\ConfigInterface $_resource
     * @param \Magento\Framework\App\Cache\StateInterface $state
     * @param \Magento\Framework\Filesystem\Driver\File $fileDriver
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\App\Config\ConfigResource\ConfigInterface $_resource,
        \Magento\Framework\App\Cache\StateInterface $state,
        \Magento\Framework\Filesystem\Driver\File $fileDriver,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
    )
    {
        parent::__construct($context);
        $this->directoryList = $directoryList;
        $this->_resource = $_resource;
        $this->fileDriver = $fileDriver;
        $this->_state = $state;
        $this->_cacheTypeList = $cacheTypeList;
    }

    public function getUrlBlockFile()
    {
        return $this->scopeConfig->getValue(self::BLOCK_FILE);
    }

    public function getUrlLocationFile()
    {
        return $this->scopeConfig->getValue(self::LOCATION_FILE);
    }

    /**
     * @param bool $flushCache
     * @return bool
     */
    public function isDone($flushCache = true)
    {
        if ($flushCache) {
            $this->flushConfigCache();
        }

        return ($this->scopeConfig->getValue('amgeoip/import/location')
            && $this->scopeConfig->getValue('amgeoip/import/block'));
    }

    public function resetDone()
    {
        $this->_resource->saveConfig('amgeoip/import/block', 0, 'default', 0);
        $this->_resource->saveConfig('amgeoip/import/location', 0, 'default', 0);
    }

    public function getDirPath($action)
    {
        $varDir = $this->directoryList->getPath('var');

        if ($action == 'download_and_import') {
            $dir = $varDir . DIRECTORY_SEPARATOR . 'amasty' . DIRECTORY_SEPARATOR . 'geoip' . DIRECTORY_SEPARATOR
                . 'amasty_files';
        } else {
            $dir = $varDir . DIRECTORY_SEPARATOR . 'amasty' . DIRECTORY_SEPARATOR . 'geoip';
        }

        return $dir;
    }

    public function getCsvFilePath($type, $action)
    {
        $dir  = $this->getDirPath($action);
        $file = $dir . DIRECTORY_SEPARATOR . $this->_geoipCsvFiles[$type];

        return $file;
    }

    public function getFilePath($type, $action)
    {
        $dir = $this->getDirPath($action);
        $file = $dir . DIRECTORY_SEPARATOR . $this->_geoipRequiredFiles[$type];
        return $file;
    }

    /**
     * is file exist
     *
     * @param string $filePath
     *
     * @return bool
     */
    public function isFileExist($filePath)
    {
        try {
            return $this->fileDriver->isExists($filePath);
        } catch (\Magento\Framework\Exception\FileSystemException $exception) {
            return false;
        }
    }

    public function flushConfigCache()
    {
        $cacheType = \Magento\Framework\App\Cache\Type\Config::TYPE_IDENTIFIER;

        if ($this->isCacheEnabled($cacheType)) {
            $this->_cacheTypeList->cleanType($cacheType);
        }
    }

    public function isCacheEnabled($type)
    {
        if (!isset($this->_cacheEnabled)) {
            $this->_cacheEnabled = $this->_state->isEnabled($type);
        }

        return $this->_cacheEnabled;
    }
}
