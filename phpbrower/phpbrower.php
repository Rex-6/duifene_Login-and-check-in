<?php
namespace phpbrower;
/**
 * 
 */
class Phpbrower
{
	private $ch;
	private $headers;
	private $header;

	function __construct()
	{
		$this->randua();
		$this->ch = curl_init();
		$this->headers = array();
		$this->header = array();
		$options[CURLOPT_RETURNTRANSFER] = true;	//不直接输出内容
		$options[CURLOPT_SSL_VERIFYPEER] = false;	//关闭SSL检查
		$options[CURLOPT_COOKIEJAR] = tempnam('F:\Work\PCampus\runtime\cache','cookie');	//CookieJar
		$options[CURLOPT_HTTPHEADER] = $this->headers;	//自定义头部
		curl_setopt_array($this->ch, $options);
	}

	//随机UA
	function randua()
	{
		$this->header('User-Agent','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36');
	}

	//自定义头部
	function header($name,$value)
	{
		$this->header[$name] = $value;
		$this->headers = array();
		foreach ($this->header as $key => $value) {
			$this->headers[] =  $key.':'.$value;
		}
	}

	//发送post请求
	function post($url,$data=false)
	{
		//启动post请求
		curl_setopt($this->ch, CURLOPT_POST, 1);
		//设置访问的Url
		curl_setopt($this->ch, CURLOPT_URL, $url);
		//POST数据
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
		return curl_exec($this->ch);
	}

	//发送get请求
	function get($url,$data=false)
	{
		if($data){
			$url .= '?'.http_build_query($data);
		}
		echo($url);
		//设置访问的Url
		curl_setopt($this->ch, CURLOPT_URL, $url);
		return curl_exec($this->ch);
	}
}