<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require ('vendor/autoload.php');
require('vendor/zendframework/zend-http/src/Headers.php');
require('vendor/zendframework/zend-http/src/Request.php');
require('vendor/zendframework/zend-http/src/Response.php');

/*Token Generated from SYstem Integratio*/
$token = 'xx0om2p4tthknn68pusrths6qn9bwtuv';
$httpHeaders = new \Zend\Http\Headers();
$httpHeaders->addHeaders(
[   'Authorization' => 'Bearer ' . $token,
   'Accept' => 'application/json',
   'Content-Type' => 'application/json'
]);

$request = new \Zend\Http\Request();
$request->setHeaders($httpHeaders);
$request->setUri('http://cna.devsitepro.com/rest/V1/customers/search');
$request->setMethod(\Zend\Http\Request::METHOD_GET);
$params = new \Zend\Stdlib\Parameters([
   'searchCriteria' => '*'
]);
$request->setQuery($params);
$client = new \Zend\Http\Client();
$options = [
   'adapter'   => 'Zend\Http\Client\Adapter\Curl',
   'curloptions' => [CURLOPT_FOLLOWLOCATION => true],
   'maxredirects' => 0,
   'timeout' => 30
];
$client->setOptions($options);
$response = $client->send($request);
echo $response->getBody();
?>

