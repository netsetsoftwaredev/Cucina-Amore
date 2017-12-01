<?php
namespace Cna\Theme\Block;
class Posts extends \Magento\Framework\View\Element\Template
{
    public function getMediaByHashtag($hashtag = null, $count = 16, $assoc = false, $comment_count = false) {
        if ( empty($hashtag) || !is_string($hashtag) )
        {
            return false;
        }
	$baseUrl = "https://www.instagram.com/explore/tags/{$hashtag}/?__a=1";
	$url = $baseUrl;
    	$json = json_decode(file_get_contents($url));
        $media = $json->tag->media->nodes;
        return $media;
    }
    protected $curlProxy = array();
    public function setCurlProxy(array $config) {
        foreach ($config as $k => $v) {
            if ((in_array($k, array(CURLOPT_HTTPPROXYTUNNEL)) && is_bool($v))
                || (in_array($k, array(CURLOPT_PROXYAUTH, CURLOPT_PROXYPORT, CURLOPT_PROXYTYPE)) && is_int($v))
                || (in_array($k, array(CURLOPT_PROXY, CURLOPT_PROXYUSERPWD)) && is_string($v))
            ) {
                $this->curlProxy[$k] = $v;
            }
        }
    }
    protected function getContentsFromUrl($parameters, $url = "https://www.instagram.com/query/") {
        if (!function_exists('curl_init')) {
            return false;
        }
        $random = $this->generateRandomString();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if ($parameters) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'q='.$parameters);
        }
        foreach ($this->curlProxy as $k => $v) {
            curl_setopt($ch, $k, $v);
        }
        $headers = array();
        $headers[] = "Cookie:  csrftoken=$random;";
        $headers[] = "X-Csrftoken: $random";
        $headers[] = "Referer: https://www.instagram.com/";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    protected function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
