<?php

class Content extends Contents 
{
	
	
	public $dynamicAttributes;
	public $specialTextFields;
//	public $Twitter;
	
	static function model($className=__CLASS__) {
		return parent::model($className);
	}
 
	public function defaultScope(){

		return array(
			'condition'=>"type='CONTENT'",			
		);
	}
	

	public function __get ( $name ) {
//		if ($name == 'Twitter'){
//			
//			if ( isset ( $this->dynamicAttributes[$name]) ){
//				echo 'isset';
//			}
//			echo gettype($this->dynamicAttributes);
//			if (array_key_exists($name, $this->dynamicAttributes)){
//				echo 'van';
//			}
//			print_r($this->dynamicAttributes); die();
//		}
			if ( is_array($this->dynamicAttributes) && array_key_exists($name, $this->dynamicAttributes) ) return $this->dynamicAttributes [ $name ];
			else{
					return parent::__get ( $name );
			}
	}

	public function __set ( $attr, $value ) {
			try {
					parent::__set ( $attr, $value );
			} catch ( CException $e ) {
					$this->dynamicAttributes [ $attr ] = $value;
			}
	}	
	
	
//	public function onAfterConstruct($event){
//		parent::onAfterConstruct($event);
//		echo '+++++++++';
//		die();
//	}
	
		
	public function rules()
	{
		
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$rules =  CMap::mergeArray(parent::rules(), 
			array(
				array('lead_image, hover_lead_image', 'upload'), // upload lead image
//				array('Twitter', 'safe'),
			)
		);
		
		if ($this->page->getParam('specialTextFields')){
			$rules = CMap::mergeArray($rules, $this->_addRules());
		}
		return $rules;
	}
	

	
	private function _getSpecialTextFields(){
		if ($this->page->getParam('specialTextFields') !== NULL ){
			$elements = explode(';', $this->page->getParam('specialTextFields'));
			$internalIdList = '';
			foreach($elements as $i =>  $elem){
				$array = explode(':', $elem);
				$id = $array[0];
				$fields = $array[1];
				$this->specialTextFields[$id] = $fields;
				foreach(explode(',', $fields) as $field){
					$this->__set($field, $this->getParam($field));
				}
			}
		}
	}
		
	private function _addRules(){
		
		if (! $this->dynamicAttributes)
			$this->_getSpecialTextFields();
		
		if (isset($this->specialTextFields[$this->internal_id])){
			return array(
				array($this->specialTextFields[$this->internal_id], 'safe')
			);
		}
		else{
			return array();
		}
	}
	
	public function afterFind(){
	
				$this->_getSpecialTextFields();

		return parent::afterFind();
	}
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		
		$labels = 				array(
					'id' => 'ID',
					'label' => 'Label',
					'type' => 'Type',
					'seq' => 'Seq',
					'status' => 'Status',
					'lead' => 'Lead',
					'content' => 'Content',
					'registered' => 'Registered',
					'page_id' => 'Page',
					'parent_id' => 'Parent',
					'lead_image' => 'Lead Image',
//					'Twitter' => 'aaa',
		);
		
		if ($leadLabel = $this->leadNeeded()){
			
			$labels = CMap::mergeArray($labels, array('lead' => $leadLabel ) );
		}
		return CMap::mergeArray(
				parent::attributeLabels(), $labels);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('seq',$this->seq);
		$criteria->compare('status',$this->status);
		$criteria->compare('lead',$this->lead,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('registered',$this->registered,true);
		$criteria->compare('page_id',$this->page_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('lead_image',$this->lead_image,true);

		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}	
	
	
	public function getCrudConfig()
	{
		// we need tinymce
		Yii::app()->clientScript->registerTinyMce();
				$this->_getSpecialTextFields();
			$fields = array(
				'elements'=>array(
					'<fieldset class="wizard-step"><legend class="wizard-label"><i class="icol-pencil"></i>Edit</legend>',
					'label'=>array(
						'type'=>'text',
						'class' => 'large required',
					),
					(($this->page->url == 'about-us' ) ? '<div class="row"><b>Hint for hover images:</b><br />1. Upload your image by following this naming convention myImage.png => myImage<b>_hover</b>.png. <br />2. While inserting the image, choose the "Appearence" tab on the "Insert/Edit Image" dialog and select hover-image from the "class" dropdown. </div>' : ''),
					'content'=>array(
						'type'=>'textarea',
						'class' => 'large tinyMce',
					),
					'internal_id' => array(
						'type' => 'text',
						'readonly' => 'readonly',
					),
					'registered' => array(
						'type' => 'text',
						'class' => 'large dateTimePicker',
					),
					'status' => array(
						'type'		=> 'dropdownlist',
						'items'	=> $this->statusOptions(),
					),
					'page_id' => array(
						'type' => 'hidden',
					),
					'</fieldset>',

				),
				'class' => 'mws-form',
				'enctype' => 'multipart/form-data',
				'buttons'=>array(
					'save'=>array(
						'type'=>'submit',
						'label'=>'Update',
					),
					'tempSave'=>array(
						'type'=>'submit',
						'label'=>'Temporary Save for checking',
					),
				),			
			);			
			
			if ($this->leadNeeded()){
						$fields = CMap::mergeArray($fields, 
								array('elements' => array(
									'lead' => array(
										'type' => 'textarea',
										'class'=> 'large',
									)
								))

						);
				
			}
			
			
			if ($this->dynamicAttributes){
				$dyns = array();
				foreach($this->dynamicAttributes as $attr => $value){
//					echo $this->dynamicAttributes[$attr]; die();
//					echo $this->__get($attr); die();
//					echo $attr . '++++++++++++++++++++++++';
//					foreach( explode(',', $attrs) as $attr ){ 
						$fields = CMap::mergeArray($fields, 
								array('elements' => array(
									$attr => array(
										'type' => 'text',
									)
								))

						);
//					}
				}
			}
//			print_r($fields);
			
                /* if lead image upload needed */
                if ($this->getPageParams('leadImage')){
                    $imageField = array(
                            'elements' => array(
//								'<fieldset class="wizard-step"><legend class="wizard-label"><i class="icol-map"></i>Lead image</legend>',                                
								'lead_image' => array('type' => 'file'), 
                                ($this->lead_image ? '
                                    <div class="row leadImagePreview">
                                        <img class="imageDelete" src="' . $this->lead_image . '" /><br />
                                            <button class="btn btn-danger" >Delete image</button>
                                    </div>
                                        ' : '' ), 
//                                '</fieldset>',
                            ),
                        );
                    $fields = CMap::mergeArray($fields, $imageField);
                }
		if (in_array( $this->internal_id , $this->page->paramToArray('hoverLeadImage')))
		{
			$fields = CMap::mergeArray($fields, array(
						'elements' => array(
						'hover_lead_image' => array('type' => 'file'), 
							($this->lead_image ? '<img src="' . $this->hover_lead_image . '" />' : '' ), 
						),
			));
		}
				
				
				
		return $fields;
		
	}

	
	private function leadNeeded(){
			if ($this->page->getParam('leadNeeded')){
				
				foreach($this->page->paramToArray( 'leadNeeded' ) as $id){
					$label = null;
					if (preg_match('/:/', $id )){
						$slices = explode( ':', $id );
						$id = $slices[0];
						$label = $slices[1];
						
					}
					if ($id == $this->internal_id){
						return $label;
					}	
						
				}
			}
			return false;
		
	}
	
	public function getFixContentIdOptions(){
		if ($this->page->fixContentIds){
			$array = array();
			foreach($this->page->fixContentIds as $internalIds)
				$array[$internalIds] = $internalIds;

			return $array;
		}
		return NULL;
		
	}
	
	
	public function beforeSave(){
		
		if ($this->isNewRecord)
			$this->type='CONTENT';
		
		if ($this->page->getParams('specialTextFields') && is_array($this->dynamicAttributes)){
			foreach($this->dynamicAttributes as $key => $value){
				$this->setParam($key, $value, false);
			}
		}
		
		/* if only 1 record can be active -> deactivate the others */
		if ($this->status == 1 && (!in_array($this->internal_id, $this->page->paramToArray('moreCanActive') )) ){
			$crit = new CDbCriteria;
			$crit->condition = 'page_id=:page_id AND internal_id=:internal_id AND status != 2';
			$crit->params = array(
				':page_id' => $this->page_id,
				':internal_id' => $this->internal_id,
			);
			$this->updateAll(array('status' => 0), $crit);
			
		}
		
		return parent::beforeSave();
	}
	

	
}