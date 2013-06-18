<?php


class Vod extends CApplicationComponent
{

	private $_apiKey;
	private $_projects;
	
	public function setApiKey($apiKey)
	{
		$this->_apiKey = $apiKey;
		return $this;
		
	}
	
	
	public function getProjects(){

		if (!$this->_projects)
			$this->_projects = json_decode( Yii::app()->CURL->run($this->apiProjectsUrl));
		
		echo 'aaaaaaa' . gettype($this->_projects) ;
		print_r($this->_projects);
		return $this->_projects;
		
		
	}
	
	public function getApiProjectsUrl()
	{
		//guardian
		// http://api.dev.rightster.com/xml/external/Contentmgr/getProjects?oauth_consumer_key=e9cde3ca-dde7-ccf7-95d4-f1d7f2d6c6f6
		// http://api.live.rightster.com/json/external/contentmgr/getProjects?oauth_consumer_key=e9cde3ca-dde7-ccf7-95d4-f1d7f2d6c6f6
		// http://api.rightster.com/json/external/contentmgr/getProjects?oauth_consumer_key=e9cde3ca-dde7-ccf7-95d4-f1d7f2d6c6f6
		// mbf
		//http://api.live.rightster.com/json/external/contentmgr/getVideosForProject?oauth_consumer_key=f6faf3ed-f1d3-c2df-a6e3-e6d3ede7cfc5
		//
		
		return YII_DEBUG ?  'http://api.rightster.com/json/external/contentmgr/getProjects?oauth_consumer_key=' . $this->_apiKey : 
						'http://api.rightster.com/json/external/contentmgr/getProjects?oauth_consumer_key=' . $this->_apiKey;
	}
	
	
	
}