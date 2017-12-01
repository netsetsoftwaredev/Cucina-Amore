<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Storelocator
 */


namespace Amasty\Storelocator\Model\Import;

use Magento\CatalogImportExport\Model\Import\Product as ImportProduct;
use Amasty\Storelocator\Model\Import\Validator\RowValidatorInterface as ValidatorInterface;
use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface;
use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingError;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\ImportExport\Model\Import;

class Location extends \Magento\ImportExport\Model\Import\Entity\AbstractEntity
{
    const VALUE_ALL_WEBSITES = 'All Websites';

    const COL_ID = 'id';

    const COL_NAME = 'name';

    const COL_COUNTRY = 'country';

    const COL_CITY = 'city';

    const COL_ZIP = 'zip';

    const COL_ADDRESS = 'address';

    const COL_STATE = 'state';

    const COL_DESCRIPTION = 'description';

    const COL_PHONE = 'phone';

    const COL_EMAIL = 'email';

    const COL_STORES = 'stores';

    const COL_STATUS = 'status';

    const COL_PHOTO = 'store_img';

    const MARKER = 'marker_img';

    const COL_LAT = 'lat';

    const COL_LNG = 'lng';

    const VALIDATOR_MAIN = 'validator';

    const VALIDATOR_COUNTRY = 'country';

    const VALIDATOR_PHOTO = 'photo';

    const TABLE_AMASTY_LOCATION = 'amasty_amlocator_location';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = [
        ValidatorInterface::ERROR_INVALID_PHOTO => 'Invalid Photo Please Check It',
        ValidatorInterface::ERROR_COUNTRY_IS_EMPTY => 'Invalid Country',
        ValidatorInterface::ERROR_ID_IS_EMPTY => 'Id Field Is Empty',
        ValidatorInterface::ERROR_MEDIA_URL_NOT_ACCESSIBLE => 'can\'t access to Media Url',
        ValidatorInterface::ERROR_NAME_IS_EMPTY => 'Name Is Empty'
    ];

    /**
     * If we should check column names
     *
     * @var bool
     */
    protected $needColumnCheck = true;

    /**
     * Valid column names
     * @array
     */

    protected $validColumnNames = [
        self::COL_ID,
        self::COL_NAME,
        self::COL_COUNTRY,
        self::COL_CITY,
        self::COL_ZIP,
        self::COL_ADDRESS,
        self::COL_STATE,
        self::COL_DESCRIPTION,
        self::COL_PHONE,
        self::COL_EMAIL,
        self::COL_STORES,
        self::COL_STATUS,
        self::COL_PHOTO,
        self::MARKER,
        self::COL_LAT,
        self::COL_LNG
    ];

    protected $coordinatesFields = [
        self::COL_COUNTRY,
        self::COL_CITY,
        self::COL_STATE,
        self::COL_ZIP,
        self::COL_ADDRESS
    ];

    /**
     * @var \Amasty\Storelocator\Model\Import\Proxy\Location\ResourceModelFactory
     */
    protected $_resourceFactory;

    /**
     * Media files uploader
     *
     * @var \Magento\CatalogImportExport\Model\Import\Uploader
     */
    protected $_fileUploader;

    /**
     * @var \Magento\CatalogImportExport\Model\Import\UploaderFactory
     */
    protected $_uploaderFactory;

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    protected $_mediaDirectory;

    /**
     * @var array
     */
    protected $_validators = [];

    /**
     * Permanent entity columns.
     *
     * @var string[]
     */
    protected $_permanentAttributes = [self::COL_ID];

    /**
     * Column names that holds images files names
     *
     * @var string[]
     */
    protected $_imagesArrayKeys = ['photo'];
    /**
     * @var \Magento\Framework\Filesystem\File\ReadFactory
     */
    private $readFactory;
    /**
     * @var \Magento\Framework\HTTP\Adapter\CurlFactory
     */
    private $curlFactory;

    public function __construct(
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\ImportExport\Helper\Data $importExportData,
        \Magento\ImportExport\Model\ResourceModel\Import\Data $importData,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\ImportExport\Model\ResourceModel\Helper $resourceHelper,
        \Magento\Framework\Stdlib\StringUtils $string,
        ProcessingErrorAggregatorInterface $errorAggregator,
        \Magento\CatalogImportExport\Model\Import\UploaderFactory $uploaderFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Filesystem\File\ReadFactory $readFactory,
        \Magento\Framework\HTTP\Adapter\CurlFactory $curlFactory,

        \Amasty\Storelocator\Model\Import\Proxy\Location\ResourceModelFactory $resourceModelFactory,
        \Amasty\Storelocator\Model\Import\Validator\Country $validatorCountry,
        \Amasty\Storelocator\Model\Import\Validator\Photo $validatorPhoto,
        Validator $validator
    ) {
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::ROOT);
        $this->_uploaderFactory = $uploaderFactory;
        $this->jsonHelper = $jsonHelper;
        $this->_importExportData = $importExportData;
        $this->_resourceHelper = $resourceHelper;
        $this->_dataSourceModel = $importData;
        $this->_connection = $resource->getConnection('write');
        $this->_validators[self::VALIDATOR_MAIN] = $validator->init($this);
        //add validators for Country and Image
        $this->_validators[self::VALIDATOR_PHOTO] = $validatorPhoto;
        $this->_validators[self::VALIDATOR_COUNTRY] = $validatorCountry;
        $this->errorAggregator = $errorAggregator;
        foreach (array_merge($this->errorMessageTemplates, $this->_messageTemplates) as $errorCode => $message) {
            $this->getErrorAggregator()->addErrorMessageTemplate($errorCode, $message);
        }
        $this->readFactory = $readFactory;
        $this->curlFactory = $curlFactory;
        $this->_resourceFactory = $resourceModelFactory;
    }


    protected function _getValidator($type)
    {
        return $this->_validators[$type];
    }

    /**
     * Entity type code getter.
     *
     * @return string
     */
    public function getEntityTypeCode()
    {
        return 'amasty_storelocator';
    }

    /**
     * Row validation.
     *
     * @param array $rowData
     * @param int $rowNum
     * @return bool
     */
    public function validateRow(array $rowData, $rowNum)
    {
        $id = false;
        if (isset($this->_validatedRows[$rowNum])) {
            return !$this->getErrorAggregator()->isRowInvalid($rowNum);
        }
        $this->_validatedRows[$rowNum] = true;
        // BEHAVIOR_DELETE use specific validation logic
        if (\Magento\ImportExport\Model\Import::BEHAVIOR_DELETE == $this->getBehavior()) {
            if (!isset($rowData[self::COL_ID])) {
                $this->addRowError(ValidatorInterface::ERROR_ID_IS_EMPTY, $rowNum);
                return false;
            }
            return true;
        }

        $this->_processedEntitiesCount++;

        if (!$this->_getValidator(self::VALIDATOR_MAIN)->isValid($rowData)) {
            foreach ($this->_getValidator(self::VALIDATOR_MAIN)->getMessages() as $message) {
                $this->addRowError($message, $rowNum);
            }
        }

        if (!$this->_getValidator(self::VALIDATOR_COUNTRY)->isValid($rowData)) {
            foreach ($this->_getValidator(self::VALIDATOR_MAIN)->getMessages() as $message) {
                $this->addRowError($message, $rowNum);
            }
        }

        if (isset($rowData[self::COL_ID]) && $rowData[self::COL_ID] != "") {
            $id = $rowData[self::COL_ID];
        }

        if (false === $id) {
            $this->addRowError(ValidatorInterface::ERROR_ID_IS_EMPTY, $rowNum);
        }
        return !$this->getErrorAggregator()->isRowInvalid($rowNum);
    }

    /**
     * Validate data rows and save bunches to DB
     *
     * @return $this
     */
    protected function _saveValidatedBunches()
    {
        $source = $this->_getSource();
        $source->rewind();
        while ($source->valid()) {
            try {
                $rowData = $source->current();
            } catch (\InvalidArgumentException $e) {
                $this->addRowError($e->getMessage(), $this->_processedRowsCount);
                $this->_processedRowsCount++;
                $source->next();
                continue;
            }

           // $rowData = $this->_customFieldsMapping($rowData);

            $this->validateRow($rowData, $source->key());
            $source->next();
        }
       // $this->checkUrlKeyDuplicates();
        //$this->getOptionEntity()->validateAmbiguousData();
        return parent::_saveValidatedBunches();
    }

    /**
     * Returns an object for upload a media files
     *
     * @return \Magento\CatalogImportExport\Model\Import\Uploader
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getUploader()
    {
        if (is_null($this->_fileUploader)) {
            $this->_fileUploader = $this->_uploaderFactory->create();

            $this->_fileUploader->init();

            $dirConfig = DirectoryList::getDefaultConfig();
            $dirAddon = $dirConfig[DirectoryList::MEDIA][DirectoryList::PATH];

            $DS = DIRECTORY_SEPARATOR;

            if (!empty($this->_parameters[Import::FIELD_NAME_IMG_FILE_DIR])) {
                $tmpPath = $this->_parameters[Import::FIELD_NAME_IMG_FILE_DIR];
            } else {
                $tmpPath = $dirAddon . $DS . $this->_mediaDirectory->getRelativePath('import');
            }

            if (!$this->_fileUploader->setTmpDir($tmpPath)) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('File directory \'%1\' is not readable.', $tmpPath)
                );
            }
            $destinationDir = "wysiwyg/storelocator";
            $destinationPath = $dirAddon . $DS . $this->_mediaDirectory->getRelativePath($destinationDir);

            $this->_mediaDirectory->create($destinationPath);
            if (!$this->_fileUploader->setDestDir($destinationPath)) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('File directory \'%1\' is not writable.', $destinationPath)
                );
            }
        }
        return $this->_fileUploader;
    }

    /**
     * Uploading files into the "amasty/amlocator media folder.
     * Return a new file name if the same file is already exists.
     *
     * @param string $fileName
     * @return string
     */
    protected function uploadMediaFiles($fileName, $renameFileOff = false)
    {
        try {
            $res = $this->getUploader()->move($fileName, $renameFileOff);
            return $res['file'];
        } catch (\Exception $e) {
            return '';
        }
    }

    protected function _importData()
    {
        if (\Magento\ImportExport\Model\Import::BEHAVIOR_DELETE == $this->getBehavior()) {
            $this->deleteLocation();
        } elseif (\Magento\ImportExport\Model\Import::BEHAVIOR_REPLACE == $this->getBehavior()) {
            $this->saveAndReplaceLocations();
        } elseif (\Magento\ImportExport\Model\Import::BEHAVIOR_APPEND == $this->getBehavior()) {
            $this->saveAndReplaceLocations();
        }

        return true;
    }

    /**
     * Deletes Advanced price data from raw data.
     *
     * @return $this
     */
    public function deleteLocation()
    {
        $listIds = [];
        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            foreach ($bunch as $rowNum => $rowData) {
                $this->validateRow($rowData, $rowNum);
                if (!$this->getErrorAggregator()->isRowInvalid($rowNum)) {
                    $listIds[] = $rowData[self::COL_ID];
                }
                if ($this->getErrorAggregator()->hasToBeTerminated()) {
                    $this->getErrorAggregator()->addRowToSkip($rowNum);
                }
            }
        }
        $tableName = $this->_resourceFactory->create()->getTable(self::TABLE_AMASTY_LOCATION);
        try {
            $this->countItemsDeleted += $this->_connection->delete(
                $tableName,
                $this->_connection->quoteInto(self::COL_ID . ' IN (?)', $listIds)
            );
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Save and replace Locations
     *
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function saveAndReplaceLocations()
    {
        $behavior = $this->getBehavior();
        if (\Magento\ImportExport\Model\Import::BEHAVIOR_REPLACE == $behavior) {
            $this->_cachedSkuToDelete = null;
        }
        $locationsRows = [];
        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            $locations = [];
            foreach ($bunch as $rowNum => $rowData) {
                if (!$locationsRows) {
                    foreach ($rowData as $key => $value) {
                        $locationsRows[] = $key;
                    }
                }
                if (!$this->validateRow($rowData, $rowNum)) {
                    $this->addRowError(ValidatorInterface::ERROR_ID_IS_EMPTY, $rowNum);
                    continue;
                }
                if ($this->getErrorAggregator()->hasToBeTerminated()) {
                    $this->getErrorAggregator()->addRowToSkip($rowNum);
                    continue;
                }
                $rowId = $rowData[self::COL_ID];
                if (!empty($rowData[self::COL_ID])) {
                    $locationInfo = [];
                    foreach ($this->coordinatesFields as $coordinatesField) {
                        $locationInfo[] = $rowData[$coordinatesField];
                    }
                    $coordinates = $this->getCoordinates(implode(' ', $locationInfo));
                    if (is_array($coordinates)) {
                        $locationsRows[] = 'lat';
                        $locationsRows[] = 'lng';
                    }

                    foreach ($locationsRows as $key) {
                        switch ($key) {
                            case 'country':
                                $locations[$rowId][$key] = $this->checkCountry($rowData[$key]);
                                break;

                            case 'store_img':
                                $uploadedFile = '';
                                if (!empty(trim($rowData[$key]))) {
                                    $uploadedFile = $this->uploadMediaFiles(trim($rowData[$key]), true);
                                    if (!$uploadedFile) {
                                        $this->addRowError(
                                            ValidatorInterface::ERROR_MEDIA_URL_NOT_ACCESSIBLE,
                                            $rowNum,
                                            null,
                                            null,
                                            ProcessingError::ERROR_LEVEL_NOT_CRITICAL
                                        );
                                    }
                                }
                                $locations[$rowId][$key] = $uploadedFile;
                                break;

                            case 'marker_img':
                                $uploadedMarker = '';
                                if (!empty(trim($rowData[$key]))) {
                                    $uploadedMarker = $this->uploadMediaFiles(trim($rowData[$key]), true);
                                    if (!$uploadedMarker) {
                                        $this->addRowError(
                                            ValidatorInterface::ERROR_MEDIA_URL_NOT_ACCESSIBLE,
                                            $rowNum,
                                            null,
                                            null,
                                            ProcessingError::ERROR_LEVEL_NOT_CRITICAL
                                        );
                                    }
                                }
                                $locations[$rowId][$key] = $uploadedMarker;
                                break;

                            case 'lat':
                                $locations[$rowId][$key] = $coordinates[$key];
                                break;

                            case 'lng':
                                $locations[$rowId][$key] = $coordinates[$key];
                                break;

                            case 'stores':
                                if (isset($rowData[$key])) {
                                    if ($rowData[$key] == 'all') {
                                        $locations[$rowId][$key] = ',0,';
                                    } else {
                                        $locations[$rowId][$key] = ',' . $rowData[$key] . ',';
                                    }
                                }
                                break;

                            default:
                                $locations[$rowId][$key] = $rowData[$key];
                                break;
                        }
                    }
                }

            }
            $this->saveLocation($locations, self::TABLE_AMASTY_LOCATION);
        }

        return $this;
    }

    /**
     * Save product prices.
     *
     * @param array $locations
     * @param string $table
     * @return $this
     */
    protected function saveLocation(array $locations, $table)
    {
        $tableName = $this->_resourceFactory->create()->getTable($table);
        $delLocationIds = [];
        foreach ($locations as $location) {
            $delLocationIds[] = $location[self::COL_ID];
        }
        if (Import::BEHAVIOR_APPEND != $this->getBehavior()) {
            $this->_connection->delete(
                $tableName,
                $this->_connection->quoteInto('id IN (?)', $delLocationIds)
            );
        }

        $this->_connection->insertOnDuplicate($tableName, $locations);

        return $this;
    }

    protected function checkCountry($country)
    {
        /** @var \Amasty\Storelocator\Model\Import\Validator\Country $validator */
        $validator = $this->_getValidator(self::VALIDATOR_COUNTRY);
        if (strlen($country) > 2) {
            $country = $validator->getCountryByName($country);
        }
        return $country;
    }

    public function getCoordinates($address)
    {
        $address = str_replace(" ", "+", $address); // replace all the white space with "+" sign to match with google search pattern
        $url = "https://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";
        $httpAdapter = $this->curlFactory->create();
        $httpAdapter->write(\Zend_Http_Client::GET, $url, '1.1', ['Connection: close']);
        $response = $httpAdapter->read();
        $body = \Zend_Http_Response::extractBody($response);
        //generate array object from the response from the web

        $location = [ 'lat' => 0, 'lng' => 0];
        if ($body) {
            $json = $this->jsonHelper->jsonDecode($body);
            if ($json['status'] == 'OK' && isset($json['results'][0]['geometry']['location'])) {
                $location = [
                    'lat' => $json['results'][0]['geometry']['location']['lat'],
                    'lng' => $json['results'][0]['geometry']['location']['lng']
                ]  ;
            }
        }

        return $location;
    }
}
