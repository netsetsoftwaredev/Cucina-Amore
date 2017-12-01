<?php
namespace Rocktechnolabs\CLP\Controller;
 
/**
 * Inchoo Custom router Controller Router
 *
 * @author      Zoran Salamun <zoran.salamun@inchoo.net>
 */
class Router implements \Magento\Framework\App\RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;
 
    /**
     * Response
     *
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;
 
    /**
     * @param \Magento\Framework\App\ActionFactory $actionFactory
     * @param \Magento\Framework\App\ResponseInterface $response
     */
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
    }
 
    /**
     * Validate and Match
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');;
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $_objectManager->create('Rocktechnolabs\CLP\Model\CLP');
        $storeurls=$model->getCollection()->addFieldToSelect('clp_url')->addFieldToSelect('clp_id')->getData();
        $identifierUrl = trim($request->getPathInfo(), '/');
        if($request->getModuleName() === 'clp') {
            return;
        }

        foreach ($storeurls as $url) {
            if($url['clp_url']==$identifierUrl)
            {
                echo "1";
                $request->setModuleName('clp')
                ->setControllerName('index')
                ->setActionName('index')
                ->setParam('clp_id',$url['clp_id']);
                return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
            }
        }
        /*return $this->actionFactory->create(
            'Magento\Framework\App\Action\Forward',
            ['request' => $request]
        );*/
    }
}