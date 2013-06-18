<?php

class News extends Contents 
{
	
	public $indSolTypes = array(); // collection of checked industry solutions; see afterfind();
	public $indSolTypeList; // children of industry solutions 
	public $indSolFeatured = array();
	
	
	static function model($className=__CLASS__) 
	{
		return parent::model($className);
	}

	
	public function init()
	{
		/* industry solution children needed only in admin */
		if (Yii::app()->controller->id == 'admin')
		{ 
			$indsol = ModelPages::model()->findByAttributes(array('url' => 'video-solutions' ));
			$this->indSolTypeList = CHtml::listData($indsol->children, 'id', 'label');
		}
		return parent::init();
	}
	
    function defaultScope(){

        return array(
            'condition'=>"type='NEWS' AND status <> 2",			
        );
    }
	
    
	
	
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return  CMap::mergeArray(parent::rules(), 
			array(
//				array('lead_image', 'upload'), // upload lead image
				array('lead_image, hover_lead_image', 'upload'), // upload lead image
				array('_attachedVideos, indSolTypes, indSolFeatured', 'safe'),
				
			)
		);
	}


	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return CMap::mergeArray( parent::relations(), array(
			
		));
		
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		if ($this->page->getParam('videoList')){
			$labels = 	array(
					'id' => 'ID',
					'label' => 'Label',
					'type' => 'Type',
					'seq' => 'Seq',
					'status' => 'Status',
					'lead' => 'Embed Video',
					'content' => ($this->page->getParam('isCaseStudy')) ? 'Description' : 'Content',
					'registered' => 'Registered',
					'page_id' => 'Page',
					'parent_id' => 'Parent',
					'lead_image' => 'Lead Image',
					'is_external'	=> 'External',
					'url'	=> 'External Url (if you choosed the external option)',
					'hover_lead_image'	=> 'Featured image',
					'_attachedVideos'		=> 'Attached Videos',
					'indSolTypes'			=> 'Industry solutions',
					'indSolFeatured'			=> 'Featured in Industry solutions',
			);
			
		}
		else{
			$labels = 	array(
					'id' => 'ID',
					'label' => 'Label',
					'type' => 'Type',
					'seq' => 'Seq',
					'status' => 'Status',
					'lead' => 'Lead',
					'content' => ($this->page->getParam('isCaseStudy')) ? 'Description' : 'Content',
					'registered' => 'Registered',
					'page_id' => 'Page',
					'parent_id' => 'Parent',
					'lead_image' => 'Lead Image',
					'is_external'	=> 'External',
					'url'	=> 'External Url (if you choosed the external option)',
					'hover_lead_image'	=> 'Featured image',
					'_attachedVideos'		=> 'Attached Videos',
					'indSolTypes'			=> 'Industry solutions',
					'indSolFeatured'			=> 'Featured in Industry solutions',
			);
		}
		return CMap::mergeArray(parent::attributeLabels(), 
				$labels
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
	
	
	public function beforeSave(){
		
		if ($this->isNewRecord){
			$this->type='NEWS';
		}
		
		/***************************************************************************
		 * if it is casestudy and featured the previous featured of this page must be reseted
		 ***************************************************************************/		
		if ($this->page->getParam('isCaseStudy') && $this->is_featured)
		{
				$crit = new CDbCriteria;
				$crit->condition = 'page_id=:page_id';
				$crit->params = array(
					':page_id' => $this->page_id,
				);
				$this->updateAll(array('is_featured' => 0), $crit);

		}			
		
		/***************************************************************************
		 * if it is casestudy and featured ON HOME  the previous featured on homemust be reseted
		 ***************************************************************************/		
		if ($this->page->getParam('isCaseStudy') && $this->is_home_featured)
		{
				$crit = new CDbCriteria;
				$crit->condition = 'type=:type AND is_home_featured=1';
				$crit->params = array(
					':type' => $this->type,
				);
				$this->updateAll(array('is_home_featured' => 0), $crit);
		}
		
		return parent::beforeSave();
	}
	
	
        
        
	public function afterFind(){
		/*************************************************
		 * it belongs to these subpages of industry solutions
		 ************************************************/
		if (count($this->dataRelations)){
			foreach($this->dataRelations as $rel){
				$this->indSolTypes[] = $rel->parent_id;
				if ($rel->is_featured)
					$this->indSolFeatured[] = $rel->parent_id;
			}
		}
		
		
		return parent::afterFind();
	}
	
        public function afterSave()
	{
			/*==========================
			 * related industrial solutions subpages saving
			 ===========================*/
			DataRelations::model()->deleteAllByAttributes(array('content_id' => $this->id));
			if (is_array($this->indSolTypes) && count($this->indSolTypes))
			{
				$resetOtherFeatured = false;
				foreach($this->indSolTypes as $pageId)
				{
					$model = new DataRelations;
					$model->content_id = $this->id;
					$model->parent_id = $pageId;
					$model->is_featured = ( is_array($this->indSolFeatured) &&  in_array( $pageId, $this->indSolFeatured ) ) ? 1 : 0;
					$model->save();
					if ($model->is_featured){
						$crit = new CDbCriteria;
						$crit->condition = 'id <>:id AND parent_id = :page_id ';
						$crit->params = array(
							':id' => $model->id,
							':page_id' => $pageId,
						);
						DataRelations::model()->updateAll(array('is_featured' => 0), $crit);
					}
				}
				
			}
			return parent::afterSave();
	}
	
 	/*===============
	 * form configs for CForm
	 =================*/
	public function getCrudConfig()
	{
		Yii::app()->clientScript->registerTinyMce();
		
		if ($this->page->getParam('isCaseStudy') && ! $this->page->getParam('videoList')){
			$fields =  array(
				'elements'=>array(
					'<fieldset class="wizard-step"><legend class="wizard-label"><i class="icol-pencil"></i>Edit</legend>',
					'label'=>array(
						'type'=>'text',
						'class' => 'large required',
					),
					'lead'=>array(
						'type'=>'textarea',
						'class' => 'large tinyMce',
					),
					'content'=>array(
						'type'=>'textarea',
						'class' => 'large tinyMce',
					),
					'slider_content'=>array(
						'type'=>'textarea',
						'class' => 'large tinyMce',
					),
					'indSolTypes'=>array(
						'type'=>'checkboxlist',
						'class' => 'indSolTypes',
						'items' => $this->indSolTypeList,
					),
					'indSolFeatured'=>array(
						'type'=>'checkboxlist',
						'data-check-depenedency' => 'indSolTypes', // class of the dependency checkboxes
						'items' => $this->indSolTypeList,
					),
					'registered'=>array(
						'type'=>'text',
						'class' => 'large dateTimePicker',
					),
					'is_external'=>array(
						'type'=>'checkbox',
						'class' => 'niceCheckButton',
					),
					'is_featured'=>array(
						'type'=>'checkbox',
						'class' => 'niceCheckButton',
					),
					'is_home_featured'=>array(
						'type'=>'checkbox',
						'class' => 'niceCheckButton',
					),
					'url'=>array(
						'type'=>'text',
						'class' => 'large',
					),
					'status' => array(
						'type' => 'dropdownlist',
						'items' => $this->statusOptions(),
					),
					'page_id' => array(
						'type' => 'hidden',
					),
					'_attachedVideos' => array(
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
		}
		elseif ($this->page->getParam('isCaseStudy') && $this->page->getParam('videoList')){
			$fields =  array(
				'elements'=>array(
					'<fieldset class="wizard-step"><legend class="wizard-label"><i class="icol-pencil"></i>Edit</legend>',
					'label'=>array(
						'type'=>'text',
						'class' => 'large required',
					),
					'lead'=>array(
						'type'=>'textarea',
						'class' => 'large ',
					),
					'content'=>array(
						'type'=>'textarea',
						'class' => 'large tinyMce',
					),
					'registered'=>array(
						'type'=>'text',
						'class' => 'large dateTimePicker',
					),
//					'is_external'=>array(
//						'type'=>'checkbox',
//						'class' => 'niceCheckButton',
//					),
//					'is_featured'=>array(
//						'type'=>'checkbox',
//						'class' => 'niceCheckButton',
//					),
//					'is_home_featured'=>array(
//						'type'=>'checkbox',
//						'class' => 'niceCheckButton',
//					),
//					'url'=>array(
//						'type'=>'text',
//						'class' => 'large',
//					),
					'status' => array(
						'type' => 'dropdownlist',
						'items' => $this->statusOptions(),
					),
					'page_id' => array(
						'type' => 'hidden',
					),
//					'_attachedVideos' => array(
//						'type' => 'hidden',
//					),
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
		}
		
		else{
			/* it is not case study */
			$fields =  array(
				'elements'=>array(
					'<fieldset class="wizard-step"><legend class="wizard-label"><i class="icol-pencil"></i>Edit</legend>',
					'label'=>array(
						'type'=>'text',
						'class' => 'large required',
					),
					'lead'=>array(
						'type'=>'textarea',
						'class' => 'large tinyMce',
					),
					'content'=>array(
						'type'=>'textarea',
						'class' => 'large tinyMce',
					),
					'registered'=>array(
						'type'=>'text',
						'class' => 'large dateTimePicker',
					),
					'is_external'=>array(
						'type'=>'checkbox',
						'class' => 'niceCheckButton',
					),
//					'is_featured'=>array(
//						'type'=>'checkbox',
//						'class' => 'niceCheckButton',
//					),
					'url'=>array(
						'type'=>'text',
						'class' => 'large',
					),
					'status' => array(
						'type' => 'dropdownlist',
						'items' => $this->statusOptions(),
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
			
		}
                
		/* if lead image upload needed */
		if ($this->getPageParams('leadImage')){
			$imageField = array(
					'elements' => array(
						'<fieldset class="wizard-step"><legend class="wizard-label"><i class="icol-map"></i>Lead image</legend>',                                
						'lead_image' => array('type' => 'file'), 
						($this->lead_image ? '
                                    <div class="row leadImagePreview">
                                        <img class="imageDelete" src="' . $this->lead_image . '" /><br />
                                            <button class="btn btn-danger" >Delete image</button>
                                    </div>
                            
                        ' : '' ), 
						'</fieldset>',
					),
				);
			$fields = CMap::mergeArray($fields, $imageField);
		}
				
		/* it is used testimonials at HOME page */
		if ( $this->hasHoverImage() )
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
	
	
	public function indSolTypes(){
		return  array(
			'elements' => array(
				
			)
		);
	}

	
}