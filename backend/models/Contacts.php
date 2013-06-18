<?php

class Contacts extends Contents 
{
	
	public $email;
	public $firstName;
	public $lastName;
	public $company;
	public $message;
	public $linkToVideo;
	public $dob;
	public $channelUrl;
	public $phone;
	public $viewsPerMonth;
	public $location;
	public $copyrightIssues;
	public $genre;
	public $formType;
	
	static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function defaultScope(){

		return array(
			'condition'=>"type='CONTACTS'",			
		);
	}
	

	public function rules()
	{
		return CMap::mergeArray(
				parent::rules(),
				array(
					array('email, firstName, lastName, company, linkToVideo, dob, channelUrl, phone, viewsPerMonth, location, genre', 'length', 'max' => 150),
					array('copyrightIssues', 'length', 'max' => 1000),
					array('email', 'email'),
					array('email, firstName, lastName, content', 'required'),
					array('linkToVideo, channelUrl', 'url'),
					array('phone', 'safe', 'on' => 'search'),
				)
		);
		
	}
	

	public function attributeLabels() {
		return CMap::mergeArray(
			parent::attributeLabels(),
			array(
				'email' => 'Email',
				'firstName' => 'First Name',
				'lastName' => 'Last Name',
				'content'	=> 'Message',
				'company' => 'Company / Agency',
				'dob'		=> 'Date of Birth',
				'linkToVideo'	=> 'Link to download video',
				'channelUrl'	=> 'Channel or Video URL',
				'phone'		=> 'Phone Number (incl. dialling codes)',
				'viewsPerMonth' => 'Views Per Month',
				'location'		=> 'Location',
				'copyrightIssues'	=> 'Copyright issues?',
				'genre'		=> 'Genre',
			)
		);
	}
	
	
	public function getCrudConfig()
	{
		
		if ($this->formType == 'video_owners'){
			
			$fields = array(

				'elements'=>array(
					'firstName'=>array(
						'type'=>'text',
					),
					'lastName'=>array(
						'type'=>'text',
					),
					'email'=>array(
						'type'=>'text',
						'class' => 'large required',
					),
					'dob'=>array(
						'type'=>'text',
					),
					'linkToVideo'=>array(
						'type'=>'text',
					),
					'channelUrl'=>array(
						'type'=>'text',
					),
					'phone'=>array(
						'type'=>'text',
					),
					'viewsPerMonth'=>array(
						'type'=>'text',
					),
					'location'=>array(
						'type'=>'text',
					),
					'copyrightIssues'=>array(
						'type'=>'textarea',
					),
					'genre'=>array(
						'type'=>'text',
					),
					'content'=>array(
						'type'=>'textarea',
					),
					'page_id' => array(
						'type' => 'hidden',
					),

				),
				'buttons'=>array(
					'contact'=>array(
						'type'=>'submit',
						'label'=>'Send',
						'class' => 'orangeGradient',
					),
				),			
			);			
		}
		else{
			$fields = array(

				'elements'=>array(
					'firstName'=>array(
						'type'=>'text',
					),
					'lastName'=>array(
						'type'=>'text',
					),
					'company'=>array(
						'type'=>'text',
					),
					'email'=>array(
						'type'=>'text',
						'class' => 'large required',
					),

					'content'=>array(
						'type'=>'textarea',
						'class' => 'large',
					),
					'page_id' => array(
						'type' => 'hidden',
					),

				),
				'buttons'=>array(
					'contact'=>array(
						'type'=>'submit',
						'label'=>'Send',
						'class' => 'orangeGradient',
					),
				),			
			);			
		}
				
		return $fields;
		
	}

	
	
	public function beforeSave(){
		
		if ($this->isNewRecord)
			$this->type='CONTACTS';
		
		$this->label = $this->firstName . ' ' . $this->lastName;
		if ($this->formType=='video_owners'){
			$this->params_json = json_encode(array(
				'email'		=> $this->email,
				'firstName'		=> $this->firstName,
				'lastName'		=> $this->lastName,
				'linkToVideo'	=> $this->linkToVideo,
				'dob'			=> $this->dob,
				'channelUrl'	=> $this->channelUrl,
				'phone'		=> $this->phone,
				'viewsPerMonth' => $this->viewsPerMonth,
				'location'		=> $this->location,
				'copyrightIssues' => $this->copyrightIssues,
				'genre'		=> $this->genre,
			));
			
		}
		else{
			$this->params_json = json_encode(array(
				'email' => $this->email,
				'firstName' => $this->firstName,
				'lastName' => $this->lastName,
			));
		}
		$this->lead = $this->formType;
		
		return parent::beforeSave();
	}
	
	public function getEmailMessage(){
		
		return $this->content . PHP_EOL . PHP_EOL 
			. 'From: ' . $this->firstName . ' ' . $this->lastName . ' - ' . $this->email . ' (Company / agency: ' . $this->company . ')' . PHP_EOL;
		
	}
	
	
}