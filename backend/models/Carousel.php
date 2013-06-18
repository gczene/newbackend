<?php

class Carousel extends Contents 
{
	
	
    static function model($className=__CLASS__) {
        return parent::model($className);
    }
 
	public function defaultScope(){

		return array(
			'condition'=>"type='CAROUSEL'",			
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
		$labels['default'] = CMap::mergeArray(parent::attributeLabels(),
							array(
								'id' => 'ID',
								'label' => 'Label',
								'type' => 'Type',
								'seq' => 'Seq',
								'status' => 'Status',
								'lead' => 'Popup content',
								'content' => 'Content',
								'registered' => 'Registered',
								'page_id' => 'Page',
								'parent_id' => 'Parent',
								'lead_image' => 'Background image',
								'is_external'	=> 'It is a Popup'
		));
		$labels['Latest Videos'] = array(
			'lead'	=> 'Embed Video'
		);
		$labels['carousel Logos'] = array(
			'lead_image'	=> 'Logo<br /> (height must be 140px)',
		);
		if (isset( $labels[$this->internal_id] ))
			return CMap::mergeArray($labels['default'], $labels[$this->internal_id]);
		else
			return $labels['default'];
		
		
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
		
		$fields['default'] = array(
//			'title'=>'Please provide your login credential',

			'elements'=>array(
				'<fieldset class="wizard-step"><legend class="wizard-label"><i class="icol-pencil"></i>Edit</legend>',
				'label'=>array(
					'type'=>'text',
					'class' => 'large required',
				),
				'registered'=>array(
					'type'=>'text',
					'class' => 'large dateTimePicker',
				),
//				'url'=>array(
//					'type'=>'text',
//					'class' => 'large required',
//				),
				'content'=>array(
					'type'=>'textarea',
					'class' => 'large tinyMce',
				),
//				'is_external'=>array(
//					'type'=>'checkbox',
//					'class' => 'niceCheckButton',
//				),
//				'lead'=>array(
//					'type'=>'textarea',
//					'class' => 'large tinyMce',
//				),
				'status' => $this->statusException(),
				'lead_image' => array('type' => 'file'), 
				($this->lead_image ? '
                                    <div class="row leadImagePreview">
                                        <img class="imageDelete" src="' . $this->lead_image . '" /><br />
                                            <button class="btn btn-danger" >Delete image</button>
                                    </div>
                ' : '' ), 
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
		
		$fields['Latest Videos'] = array(
//			'title'=>'Please provide your login credential',

			'elements'=>array(
				'<fieldset class="wizard-step"><legend class="wizard-label"><i class="icol-pencil"></i>Edit</legend>',
				'label'=>array(
					'type'=>'text',
					'class' => 'large required',
				),
				'lead'=>array(
					'type'=>'textarea',
					'class' => 'large',
				),
				'registered'=>array(
					'type'=>'text',
					'class' => 'large dateTimePicker',
				),
				'content'=>array(
					'type'=>'textarea',
					'class' => 'large tinyMce',
				),
				'status' => $this->statusException(),
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
		
		$fields['carousel Logos'] = array(
			'elements'=>array(
				'<fieldset class="wizard-step"><legend class="wizard-label"><i class="icol-pencil"></i>Edit</legend>',
				'label'=>array(
					'type'=>'text',
					'class' => 'large required',
				),
				'status' => $this->statusException(),
				'page_id' => array(
					'type' => 'hidden',
				),
				'lead_image' => array('type' => 'file'), 
					($this->lead_image ? '
                                    <div class="row leadImagePreview">
                                        <img class="imageDelete" src="' . $this->lead_image . '" /><br />
                                            <button class="btn btn-danger" >Delete image</button>
                                    </div>
                        
                        ' : '' ), 
                'registered'=>array(
                    'type'=>'text',
                    'class' => 'large dateTimePicker',
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
		
		
		$fields = isset($fields[$this->internal_id]) ? $fields[$this->internal_id] : $fields['default'];
		
				
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
			$this->type='CAROUSEL';
		
		
		return parent::beforeSave();
	}
	
	
}