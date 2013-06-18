<div class="grid_4">
	<?php 
	/************************
	 * MENU LIST on TOP LEFT
	 *************************/ ?>
	<div class="mws-panel">
		<div class="mws-panel-header">
			<span>
				Menu list
			</span>
		</div>
		<div class="mws-panel-toolbar">
			<div class="btn-toolbar">
				<div class="btn-group">
					<a href="<?php echo Yii::app()->createUrl('admin/menu_edit'); ?>" class="btn"><i class="icol-add"></i> New page</a>
				</div>
			</div>

		</div>
		<div class="mws-panel-body">
			<table class="mws-table mws-datatable-fn trClick">
				<thead>
					<th>Label</th>
					<th>Place</th>
					<th>Status</th>
				</thead>
				<?php foreach($pages as $page): ?>
				<tr data-url="<?php echo Yii::app()->createUrl('admin/menu_edit', array('id'=> $page->id )) ?>">
					<td><?php echo  ($page->parent ? $page->parent->label . ' - ' . $page->label : $page->label) ; ?></td>
					<td><?php echo $page->place->label; ?></td>
					<td><?php echo $page->statusLabel; ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
	
	
	<?php 
	/*********************
	 * MENU PLACE EDITOR
	 **********************/ ?>
	<div class="mws-panel">
		<div class="mws-panel-header">
			<span>
				Menu places
			</span>
		</div>
		<div class="mws-panel-body createMwsForm">
			<?php echo $placeForm ?>
		</div>
		<div class="mws-panel-body">
			<table class="mws-table mws-datatable-fn trClick lastIs30" id="placeList">
				<thead>
					<th>Place label</th>
					<th>Nav</th>
				</thead>
				<?php foreach($places as $_place): ?>
				<tr data-id="<?php echo Yii::app()->encrypt->encode($_place->id) ?>" data-url="<?php echo $this->createUrl('admin/menu_edit/', array('place_id' => $_place->id)) ?>">
					<td><?php echo $_place->label ?></td>
					<td class="noClick">
						<a href="#" class="icol-cancel delete"></a>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
	<div class="mws-panel">
		<div class="mws-panel-header">
			<span>
				Assets publisher
			</span>
		</div>
		<div class="mws-panel-body">
            <?php echo CHtml::beginForm('', 'post', array('id' => 'publishAssets')); ?>
            
			<a class="btn">publish assets</a>
            <?php echo CHtml::endForm(); ?>
		</div>
	</div>
</div>
	
<?php 
/*******************************
 * RIGHT PANEL => MENU DETAILS EDITOR
 *************************************/ ?>	
<div class="mws-panel grid_4">
	<div class="mws-panel-header">
		<span>Form</span>
	</div>
	<div class="mws-panel-body createMwsForm">
		<?php echo $form; ?>
	</div>
	
	<div class="mws-panel-header">
		<span>Params</span>
	</div>
	<div class="mws-panel-body">
		<div class="mws-form">
			<div class="mws-form-inline paramEditor">
				<?php foreach($model->optionalParams as $param => $values ): ?>
				<fieldset>
					<legend>
						<?php echo $values['description'] . '<br />Options:' . $values['options']; ?>
					</legend>
					<div class="mws-form-row">
						<label class="mws-form-label"><?php echo $param ?></label>
						<div class="mws-form-item">
							<input type="text" name="<?php echo $param ?>" class="large" value="<?php echo $model->getParam($param) ?>" />
						</div>
					 </div>
				</fieldset>
				<?php endforeach; ?>
			</div>
	</div>
		
		
	</div>
</div>