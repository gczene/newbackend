<?php

class Email extends CApplicationComponent 
{
	public $from = 'no-reply@rightster.com';
	public $subject = 'Contact';
	public $to = 'gabor.czene@rightster.com';
	public $message;
	public $params = array(
		'from' => 'no-reply@rightster.com',
		'subject' => 'Contact',
		'to'	=> '',
		'message' => '',
		'name' => 'Rightster Corporate',
	);
	
	
	public function send(array $config)
	{
		// $to should be defined in config/main.php
		if ( !isset($config['to']) && Yii::app()->params['contactEmailsTo'] )
			$config['to'] = Yii::app()->params['contactEmailsTo'];
        
		// overwrite $this->params with $config
		$config = CMap::mergeArray($this->params, $config);
		
	
		$name='=?UTF-8?B?'.base64_encode( Yii::app()->name . ' site').'?=';
		$subject='=?UTF-8?B?'.base64_encode($config['subject']).'?=';
		
		// it $this->to not array, create it
		if (!is_array($config['to']))
			$config['to'] = array($config['to']);
		
        
		$config['subject'] .= ' - ' . Yii::app()->name . ' site';
		
		$headers="From: $name <{$config['from']}>\r\n".
			"MIME-Version: 1.0\r\n".
			"Content-type: text/plain; charset=UTF-8";
		try {
			foreach ($config['to'] as $to)
				mail($to,$config['subject'],$config['message'],$headers);
			
			return true;
		}
		catch(Exception $e){
			throw new CHttpException(404, $e->getMessage());
		}
	}
	
	public function setTo($to)
	{
		if ($to)
			$this->to = $to;
		return $this;
	}
	
	public function setSubject($subject)
	{
		if ($subject)
			$this->subject = $subject;
		return $this;
	}
	
	public function setMessage($message)
	{
		if ($message)
			$this->message = $message;
		return $this;
	}
	
	public function setFrom($from)
	{
		if ($from)
			$this->from = $from;
		return $this;
	}
	
	
	
}
