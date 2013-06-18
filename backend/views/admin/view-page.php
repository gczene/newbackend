<?php if ($page->fixContentIds): /* a page which has fix contents, such as advertisers */ 
	foreach($page->fixContentIds as $internalId)
	{ ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span>
			Contents of <?php echo $page->label . ' - ' . $internalId ?>
		</span>
	</div>
	<div class="mws-panel-toolbar">
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="<?php echo Yii::app()->createUrl('admin/edit_content', 
						array('page_id' => $page->id, 'internal_id' => $internalId)
						); ?>" class="btn"><i class="icol-add"></i> Add new content</a>
			</div>
		</div>
	</div>	
	<div class="mws-panel-body">
		<table class="mws-table mws-datatable-uniqe-fn trClick" data-order="DESC"  data-order-row="1" data-order="DESC" >
			<thead>
				<th>Label</th>
				<th>Registered</th>
				<th>Status</th>
			</thead>
			<?php foreach($page->contents(array('condition' => 'status <> 2' )) as $content) : 
				if ($content->internal_id == $internalId){ ?>
					<tr data-url="<?php echo Yii::app()->createUrl('admin/edit_content', array(
								'page_id' => $page->id, 
								'content_id' => $content->id, 
								'internal_id' => $content->internal_id)) ;?>">
						<td><?php echo $content->label ?></td>
						<td> <?php echo $content->registered ?></td>
						<td><?php echo $content->status  ?></td>
					</tr>
				<?php }?>
			<?php endforeach; ?>
		</table>
		
		
	</div>
</div>
	
	<?php } ?>



<?php else: ?>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span>
			Contents of <?php echo $page->label ?>
			
		</span>
	</div>
	<div class="mws-panel-toolbar">
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="<?php echo Yii::app()->createUrl('admin/edit_content', 
						array('page_id' => $page->id)
						); ?>" class="btn"><i class="icol-add"></i> Add new content</a>
			</div>
		</div>
	</div>
	<div class="mws-panel-body">		
		<table class="mws-table mws-datatable-uniqe-fn trClick" data-order-row="1" data-order="DESC" >
			<thead>
				<th>Label</th>
				<th>Registered</th>
			</thead>
			<?php foreach($page->contents as $content) : ?>
			<tr data-url="<?php echo Yii::app()->createUrl('admin/edit_content', array('page_id' => $page->id, 'content_id' => $content->id))?>">
				<td><?php echo $content->label ?></td>
				<td> <?php echo $content->registered ?></td>				
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	
	
</div>
<?php endif; ?>