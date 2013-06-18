<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span>
			SEO Edit: <?php echo $page->label ?>
		</span>
		
	</div>
	<div class="mws-panel-toolbar">
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="<?php echo Yii::app()->createUrl('admin/seo'); ?>" class="btn"><i class="icol-arrow-left"></i> Back</a>
			</div>
		</div>
	</div>
	<div class="mws-panel-body">
		<div class="createMwsForm">
			<?php echo $form ?>
		</div>
	</div>
</div>