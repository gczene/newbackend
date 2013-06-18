<?php


class Fourcontent extends Contents 
{
	
	static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
 
	function defaultScope(){

		return array(
			'condition'=>"type='FOURCONTENT' AND status <> 2",			
		);
	}
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return  CMap::mergeArray(parent::rules(), 
			array(
				array('lead_image', 'upload'), // upload lead image				
			)
		);
	}
	
//	public function attributeLabels() {
//		return CMap::mergeArray(parent::attributeLabels(),
//				array(
//					'content'	=> 'Services',
//					'content_2' => 'Case Studies',
//					'content_3' => 'Testimonials',
//					'content_4' => 'Contact',			
//				)
//		);
//	}
	
	public function getCrudConfig()
	{
		
		// we need tinymce
		Yii::app()->clientScript->registerTinyMce();
		
		$fields = array(

			'elements'=>array(
				'<fieldset class="wizard-step"><legend class="wizard-label"><i class="icol-pencil"></i>Edit</legend>',
				'<div>' . $this->page->getParam('fixContent') . '</div>',
				'label'=>array(
					'type'=>'text',
					'maxlength'=>32,
					'class' => 'large required',
				),
				'content'=>array(
					'type'=>'textarea',
					'class' => 'large tinyMce',
				),
				'content_2'=>array(
					'type'=>'textarea',
					'class' => 'large tinyMce',
				),
				'content_3'=>array(
					'type'=>'textarea',
					'class' => 'large tinyMce',
				),
				'content_4'=>array(
					'type'=>'textarea',
					'class' => 'large tinyMce',
				),
				'page_id' => array(
					'type' => 'hidden',
				),
				'<div class="fileManager"></div>',
				'</fieldset>',
				
			),
			'buttons'=>array(
				'register'=>array(
					'type'=>'submit',
					'label'=>'Register',
				),				
			),			
			'class' => 'mws-form',
			'enctype' => 'multipart/form-data',
		);			
		
                /* if lead image upload needed */
		if ($this->getPageParams('leadImage')){
			$imageField = array(
				'elements' => array(
						'<fieldset class="wizard-step"><legend class="wizard-label"><i class="icol-map"></i>Lead image</legend>',                                
						'lead_image' => array('type' => 'file'), 
						($this->lead_image ? '<img src="' . $this->lead_image . '" />' : '' ), 
						'</fieldset>',
					),
				);
				$fields = CMap::mergeArray($fields, $imageField);
		}
				
				
				
		return $fields;
		
	}
	
	

	public function beforeSave(){
		
			
		if ($this->isNewRecord)
			$this->type='FOURCONTENT';
		
		
		return parent::beforeSave();
	}
		
	
	
	
	
}