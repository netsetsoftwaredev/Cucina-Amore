<?php
namespace Iazel\RegenProductUrl\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;
use Magento\UrlRewrite\Model\UrlPersistInterface;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Store\Model\Store;
use \Magento\Framework\App\State;
use \Magento\Framework\File\Csv;
use \Magento\Framework\App\Filesystem\DirectoryList;

class ModifyProductUrlCommand extends Command
{
    /**
     * @var ProductUrlRewriteGenerator
     */
    protected $productUrlRewriteGenerator;

    /**
     * @var UrlPersistInterface
     */
    protected $urlPersist;

    /**
     * @var ProductRepositoryInterface
     */
    protected $collection;

    /**
     * @var \Magento\Framework\App\State
     */
    protected $state;

    public function __construct(
        State $state,
        Collection $collection,
        ProductUrlRewriteGenerator $productUrlRewriteGenerator,
        UrlPersistInterface $urlPersist,
		Csv $csvProcessor,
		DirectoryList $directory_list
    ) {
        $this->state = $state;
        $this->collection = $collection;
        $this->productUrlRewriteGenerator = $productUrlRewriteGenerator;
        $this->urlPersist = $urlPersist;
        $this->directory_list = $directory_list;
		$this->_csvProcessor = $csvProcessor;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('iazel:modifyurl')
            ->setDescription('Modufy url for given products')
            ->addArgument(
                'pids',
                InputArgument::IS_ARRAY,
                'Products to modify'
            )
            ->addOption(
                'store', 's',
                InputOption::VALUE_REQUIRED,
                'Use the specific Store View',
                Store::DEFAULT_STORE_ID
            );
			
        return parent::configure();
    }

    public function execute(InputInterface $inp, OutputInterface $out)
    {
		$this->state->setAreaCode('frontend');

        $store_id = $inp->getOption('store');
		
        $this->collection->addStoreFilter($store_id)->setStoreId($store_id);

        $pids = $inp->getArgument('pids');
        if( !empty($pids) )
            $this->collection->addIdFilter($pids);
		
        $this->collection->addAttributeToSelect(['url_path', 'url_key','unit_size','sku','name','type_id']);
		$this->collection->setOrder('type_id','ASC');
        $list = $this->collection->load();
		
		$objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
		
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$catalog_product_entity_varchar_tableName = $resource->getTableName('catalog_product_entity_varchar'); //gives table name with prefix
		$url_rewrite_tableName = $resource->getTableName('url_rewrite'); //gives table name with prefix
 
		//Unit Size Attribute Id
		$unit_size_attr_id = 161;
		
		$media_path = $this->directory_list->getPath('media');
		
		$filepath = $media_path . DIRECTORY_SEPARATOR ."iazel" . DIRECTORY_SEPARATOR . "import.csv";
		
		$importProductRawData = $this->_csvProcessor->getData($filepath);
		foreach ($importProductRawData as $rowIndex => $dataRow) 
		{
			$url_keys[$dataRow[0]] = $dataRow[1]; 
		}
		
		$skip_simple_prod = [];
		$used_url_keys = [];
		foreach($list as $product)
        {
			
			//$url_key = explode("-",$product->getUrlKey());
            try {
				$attributeOptionCollection = $objectManager->create(\Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\Collection::class);
		
				$optionId = $product->getUnitSize();
				
				$option = $attributeOptionCollection
					->setPositionOrder('asc')
					->setAttributeFilter($unit_size_attr_id)
					->setIdFilter($optionId)
					->setStoreFilter()
					->load()
					->getFirstItem();
					if($product->getTypeId()=="configurable") 
					{
						//$new_url_key = $product->formatUrlKey($product->getName() . " ". $product->getSku() . " ". $option->getValue() );
						$new_url_key="";
						/* if(!isset($url_keys[$product->getSku()])) {
							echo "\n".$product->getId()."=",$product->getSku(),"\n";
							continue;
						}
						 */
						$productTypeInstance = $product->getTypeInstance();
						
						$usedProducts = $productTypeInstance->getUsedProducts($product);
						
						//echo "\nConfigurable = ",$product->getId(),"\n";
						
						$ids = [];
						
						$ids[] = $product->getId();
						
						foreach ($usedProducts  as $child) 
						{
							$attributeOptionCollection_1 = $objectManager->create(\Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\Collection::class);
		
							$optId = $child->getUnitSize();
							
							$opt = $attributeOptionCollection_1
								->setPositionOrder('asc')
								->setAttributeFilter($unit_size_attr_id)
								->setIdFilter($optId)
								->setStoreFilter()
								->load()
								->getFirstItem();
							
							$tmp_key = isset($url_keys[$product->getSku()]) && $url_keys[$product->getSku()]!="" ? $url_keys[$product->getSku()] : $child->getName();
							
							$chuld_new_url_key  = $opt->getValue() != "" ? $tmp_key  ." ". $opt->getValue() :  $tmp_key  ." ". $product->getSku();
							
							$chuld_new_url_key = $product->formatUrlKey($chuld_new_url_key);
							
							$used_url_keys [] = $chuld_new_url_key;
						//	echo "\nChild = ",$child->getId(),"\n";
							
							$sql = "Update " . $catalog_product_entity_varchar_tableName . " Set value = '".$chuld_new_url_key ."' where entity_id in (". $child->getId().") and attribute_id = 119";
							$connection->query($sql);
							
							$sql = "Select * FROM " . $url_rewrite_tableName." WHERE entity_id=".$child->getId()." AND entity_type='product'";
							$urls_rewrits = $connection->fetchAll($sql);
							foreach($urls_rewrits as $key=>$url_rewrite)
							{
								$request_paths = explode("/",$url_rewrite['request_path']);
								
								$request_paths[count($request_paths)-1] = $chuld_new_url_key.".html";
								
								$sql = "Update " . $url_rewrite_tableName . " Set request_path = '".implode("/",$request_paths) ."' WHERE url_rewrite_id = ".$url_rewrite['url_rewrite_id'];
								$connection->query($sql);
							}
							
							$skip_simple_prod[] = $child->getId();
							echo "Child : ".$child->getId()."=",$chuld_new_url_key,"\n";
							
						}
						
						$pids = implode(",",$ids);
						
						if(!isset($url_keys[$product->getSku()]) || (isset($url_keys[$product->getSku()]) && $url_keys[$product->getSku()]=="") )
						{
							$tmp_key = isset($url_keys[$product->getSku()]) && $url_keys[$product->getSku()]!="" ? $url_keys[$product->getSku()] : $product->getName();
							
							$new_url_key  = $option->getValue() != "" ? $tmp_key  ." ". $option->getValue() :  $tmp_key  ." ". $product->getSku();
						}
						else{
							$new_url_key = $url_keys[$product->getSku()];
						}

						$new_url_key = $product->formatUrlKey($new_url_key);
						
						$used_url_keys [] = $new_url_key;
						
						echo "Configurable : ".$product->getId()."=",$new_url_key,"\n";
						
						$sql = "Update " . $catalog_product_entity_varchar_tableName . " Set value = '".$new_url_key ."' where entity_id in (".$pids.") and attribute_id = 119";
						$connection->query($sql);
						
						//Select Data from table
						$sql = "Select * FROM " . $url_rewrite_tableName." WHERE entity_id=".$product->getId()." AND entity_type='product'";
						$urls_rewrits = $connection->fetchAll($sql);
						foreach($urls_rewrits as $key=>$url_rewrite)
						{
							$request_paths = explode("/",$url_rewrite['request_path']);
							
							$request_paths[count($request_paths)-1] = $new_url_key.".html";
							
							$sql = "Update " . $url_rewrite_tableName . " Set request_path = '".implode("/",$request_paths) ."' WHERE url_rewrite_id = ".$url_rewrite['url_rewrite_id'];
							$connection->query($sql);
						}
						
					}
					 else
					{
						if(in_array($product->getId(),$skip_simple_prod)) continue;
						
						$key = isset($url_keys[$product->getSku()]) && $url_keys[$product->getSku()]!="" ? $url_keys[$product->getSku()] : $product->getName();
						
						$new_url_key = $product->formatUrlKey($key);
						
						if(in_array($new_url_key,$used_url_keys))
						{							
							$tmp_key = isset($url_keys[$product->getSku()]) ? $url_keys[$product->getSku()] : $product->getName();
								
							$key = $tmp_key  ." ". $option->getValue() ;
							
							$new_url_key = $product->formatUrlKey($key);
							
							if(in_array($new_url_key,$used_url_keys))
							{
								$key =$tmp_key  ." ". $product->getSku();
							
								$new_url_key = $product->formatUrlKey($key);
							
							}
						}
						//	echo "\nSimple = ",$product->getId(),"\n";
						echo "Simple : ".$product->getId()."=",$new_url_key,"\n";
						
						$used_url_keys [] = $new_url_key;
						
						$sql = "Update " . $catalog_product_entity_varchar_tableName . " Set value = '".$new_url_key ."' where entity_id = ".$product->getId()." and attribute_id = 119";
						$connection->query($sql);
						
						//Select Data from table
						$sql = "Select * FROM " . $url_rewrite_tableName." WHERE entity_id=".$product->getId()." AND entity_type='product'";
						$urls_rewrits = $connection->fetchAll($sql);
						foreach($urls_rewrits as $key=>$url_rewrite)
						{
							$request_paths = explode("/",$url_rewrite['request_path']);
							
							$request_paths[count($request_paths)-1] = $new_url_key.".html";
							
							$sql = "Update " . $url_rewrite_tableName . " Set request_path = '".implode("/",$request_paths) ."' WHERE url_rewrite_id = ".$url_rewrite['url_rewrite_id'];
							$connection->query($sql);
						}
					}
            }
            catch(\Exception $e) {
					$out->writeln('<error>Duplicated url for '. $product->getId() .' -> '.$new_url_key ." =".$e->getMessage().'</error>');				
            }
        }
    }
}
