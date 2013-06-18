<?php

class Videoslider extends Contents 
{
	
	
	static function model($className=__CLASS__) {
		return parent::model($className);
	}
 
	public function defaultScope(){

		return array(
			'condition'=>"type='VIDEOSLIDER' AND status <> 2",			
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


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'label' => 'Label',
			'type' => 'Type',
			'seq' => 'Seq',
			'status' => 'Status',
			'lead' => 'Lead',
			'content' => 'Embed Video <br/>size: 380 x 213',
			'registered' => 'Registered',
			'page_id' => 'Page',
			'parent_id' => 'Parent',
			'lead_image' => 'Thumbnail (125 x 70)',
		);
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
		

			$fields = array(
				'elements'=>array(
					'<fieldset class="wizard-step"><legend class="wizard-label"><i class="icol-pencil"></i>Edit</legend>',
					'label'=>array(
						'type'=>'text',
						'class' => 'large required',
					),
					'content'=>array(
						'type'=>'textarea',
						'class' => 'large',
					),
					'lead'=>array(
						'type'=>'textarea',
						'class' => 'large tinyMce',
					),
					'internal_id' => array(
						'type' => 'text',
						'readonly' => 'readonly',
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
				),			
			);			
		
                /* if lead image upload needed */
                if ($this->getPageParams('leadImage')){
                    $imageField = array(
                            'elements' => array(
								'lead_image' => array('type' => 'file'), 
                                ($this->lead_image ? '<img src="' . $this->lead_image . '" />' : '' ), 
                            ),
                        );
                    $fields = CMap::mergeArray($fields, $imageField);
                }
				
				
				
		return $fields;
		
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
			$this->type='VIDEOSLIDER';
		
		
		return parent::beforeSave();
	}
	

	
}