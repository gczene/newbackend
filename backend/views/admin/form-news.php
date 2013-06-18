

<?php echo CHtml::beginForm('','', array('id' => 'formNews' , 'class' => 'contentForm' ) );  ?>
<div class="row">
	<label>Title</label>
	<?php echo CHtml::activeTextField($model, 'label'); ?>
</div>

<?php if ($model->getPageParams('lead_image')): ?>
<div class="row">
	<label>Lead image</label>
	<?php echo CHtml::fileField('','', array(
		'class' => 'imageUpload', 
		'data-url' => Yii::app()->createUrl('/admin/image_upload/'),
		'data-form-data' => json_encode(array(
			'page_id'		=> $model->page_id,
			'content_id'	=> ($model->id ? $model->id : 0),
			'type'			=> 'lead_image',
		
		)),
		'rel'		=> 'th_lead_image', 
	)); ?>
	<?php echo CHtml::activeHiddenField($model, 'lead_image', array('id' => 'lead_image')); ?>
	
	<img src="<?php echo $model->lead_image; ?>" id="th_lead_image" />
</div>


<?php endif;  ?>

<div class="row">
	<label>Lead</label>
	<?php echo CHtml::activeTextarea($model, 'lead'); ?>
</div>

<div class="row">
	<label>Content</label>
	<?php echo CHtml::activeTextarea($model, 'content'); ?>
</div>

<div class="row">
	
	<?php 
		echo CHtml::activeHiddenField($model, 'id', array('name' => 'content_id'));
		echo CHtml::activeHiddenField($model, 'page_id', array('name' => 'page_id'));
		echo CHtml::button('save', array('id' => 'save') ); 
	?>
</div>



<?php echo CHtml::endForm(); ?>