<?php if (isset($page)): 
/*  1 page details */
?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span>Background image of <?php echo $page->label ?></span>
	</div>
	<div class="mws-panel-toolbar">
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="<?php echo (isset($_GET['referer'])) ? Yii::app()->encrypt->decode($_GET['referer']) : Yii::app()->createUrl('admin/backgrounds'); ?>" class="btn"><i class="icol-arrow-left"></i> Back</a>
			</div>
		</div>
	</div>		
	<div class="mws-panel-body">
		<div class="createMwsForm">
		<?php echo $form; ?>
		</div>
	</div>
</div>
<?php else: 
/* ***************
 * page list view
 *****************/ 
?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span>
			<i class="icon-file-zip"></i>
			Page backgrounds</span>
	</div>
	<div class="mws-panel-body">
		<table class="mws-table mws-datatable-fn trClick">
			<thead>
				<th>Label</th>
				<th>Parent</th>
				<th>URL</th>
			</thead>
			<?php foreach($pages as $page): ?>
			<tr data-url="<?php echo $this->createUrl('admin/backgrounds', array('page_id' => Yii::app()->encrypt->encode($page->id))); ?>">
				<td><?php echo $page->label ?></td>
				<td><?php echo $page->parentLabel ?></td>
				<td><?php echo $page->url ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
		
	</div>
	
</div>
<?php endif;  ?>