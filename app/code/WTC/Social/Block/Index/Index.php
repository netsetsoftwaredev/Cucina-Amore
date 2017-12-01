<?php

namespace WTC\Social\Block\Index;


class Index extends \Magento\Framework\View\Element\Template {

    public function __construct(\Magento\Catalog\Block\Product\Context $context, array $data = []) {

        parent::__construct($context, $data);

    }


    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
	
	public function getLatestTweets(){
		
		$screen_name = 'cucinaandamore';
		$count = 1; // How many tweets to output
		$retweets = 0; // 0 to exclude, 1 to include
	 
		// Populate these with the keys/tokens you just obtained
		$oauthAccessToken = '2444896728-0nLM6rajlPKm8jQ517nIN6LkJzwlPdLmUzN7gvX';
		$oauthAccessTokenSecret = 'hVfxfOplXeeOmZBFSow7xnEKhXJmDpDKn7vAFhLqJxtvH';
		$oauthConsumerKey = 'icpFzublca2oOWFztJsgT9luc';
		$oauthConsumerSecret = 'u3aJ8oHIEiVMYHSqpwgHrillh2R4aFIwRy2xoSaKF7JGc3ROjC';
	 
		// First we populate an array with the parameters needed by the API
		$oauth = array(
			'count' => $count,
			'include_rts' => $retweets,
			'oauth_consumer_key' => $oauthConsumerKey,
			'oauth_nonce' => time(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_timestamp' => time(),
			'oauth_token' => $oauthAccessToken,
			'oauth_version' => '1.0'
		);
	 
		$arr = array();
		foreach($oauth as $key => $val)
			$arr[] = $key.'='.rawurlencode($val);
	 
		// Then we create an encypted hash of these values to prove to the API that they weren't tampered with during transfer
		$oauth['oauth_signature'] = base64_encode(hash_hmac('sha1', 'GET&'.rawurlencode('https://api.twitter.com/1.1/statuses/user_timeline.json').'&'.rawurlencode(implode('&', $arr)), rawurlencode($oauthConsumerSecret).'&'.rawurlencode($oauthAccessTokenSecret), true));
	 
		$arr = array();
		foreach($oauth as $key => $val)
			$arr[] = $key.'="'.rawurlencode($val).'"';
	 
		// Next we use Curl to access the API, passing our parameters and the security hash within the call
		$tweets = curl_init();
		curl_setopt_array($tweets, array(
			CURLOPT_HTTPHEADER => array('Authorization: OAuth '.implode(', ', $arr), 'Expect:'),
			CURLOPT_HEADER => false,
			CURLOPT_URL => 'https://api.twitter.com/1.1/statuses/user_timeline.json?count='.$count.'&include_rts='.$retweets,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
		));
		$json = curl_exec($tweets);
		curl_close($tweets);
		
		return $json;
	}
	
	public function callInstagram($url)
    {
		$ch = curl_init();
		curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => 2
		));

		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
    }
	
	public function getRecentPostFromInstagram(){
		$client_id = 'MY CLIENT ID';
		$client_secret = 'MY CLIENT SECRET';
		
		$client_id = 'fbfd78e7d8054ce799f0c3dbbea4e077';
		$client_secret ='1de49722fe924f4a87f97fccf9efdebf';
 
		$redirect_uri = 'http://ec2-54-219-131-99.us-west-1.compute.amazonaws.com/';
		$scope = 'basic+likes+comments+relationships';

		$url = "https://api.instagram.com/oauth/authorize?client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope&response_type=code";

		if(!isset($_GET['code']))
		{
			echo '<a href="'.$url.'">Login With Instagram</a>';
		}
		else
		{
			$code = $_GET['code'];

		$apiData = array(
		  'client_id'       => $client_id,
		  'client_secret'   => $client_secret,
		  'grant_type'      => 'authorization_code',
		  'redirect_uri'    => $redirect_uri,
		  'code'            => $code
		);

		$apiHost = 'https://api.instagram.com/oauth/access_token';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiHost);
		curl_setopt($ch, CURLOPT_POST, count($apiData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$jsonData = curl_exec($ch);
		curl_close($ch);

		echo '<pre>';print_r($jsonData);die;
		$user = @json_decode($jsonData); 

		echo '<pre>';
		print_r($user);
		exit;
		}
	}
	
	public function getRecentImages(){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$model = $objectManager->create('\WTC\Instagram\Model\Instagram');
		return $model->getCollection();
	}
	
	public function getMainVideo(){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$model = $objectManager->create('\WTC\Social\Model\Social');
		$collection = $model->getCollection();
		$collection->addFieldToFilter('type', 0);
		return $collection;
	}
	
	public function getSideVideo(){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$model = $objectManager->create('\WTC\Social\Model\Social');
		$collection = $model->getCollection();
		$collection->addFieldToFilter('type', 1);
		return $collection;
	}
	
	public function getMediaUrl($url){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$media_dir = $objectManager->get('Magento\Store\Model\StoreManagerInterface')
			->getStore()
			->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

		return $media_dir.$url;
	}

}