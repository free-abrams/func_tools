<?php


namespace FreeAbrams\FuncTools\ElasticSearch;

/**
 * Created By FreeAbrams
 * Date: 2022/7/2
 */
class ElasticSearch
{
	private $url,$port;
	
	public function __construct($url, $port)
	{
		if (is_array($url)) {
			$this->url = $url['url'];
			$this->port = $url['port'];
		} else {
			$this->url = $url;
			$this->port = $port;
		}
	}
	
	public function create()
	{
	
	}
	
	public function query()
	{
	
	}
	
	public function select()
	{
	
	}
	
	public function update()
	{
	
	}
	
	public function delete()
	{
	
	}
}