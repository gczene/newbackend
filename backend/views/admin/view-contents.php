<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span>
			<i class="icon-list"></i>
			<?php echo CHtml::encode($this->pageTitle) ?></span>
		
	</div>
    
	<div class="mws-panel-toolbar">
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="<?php echo 
				 (isset($_GET['referer']) ? Yii::app()->encrypt->decode($_GET['referer']) : $this->createUrl('admin/page', array('id'=>$page->id)) )
					?>" class="btn"><i class="icol-arrow-left"></i> Back</a>
					<?php if (isset($_GET['referer'])) :?>
						<a href="<?php echo Contents::newContentUrl() ?>" class="btn"><i class="icol-add"></i> Add new content</a>
					<?php endif; ?>
			</div>
		</div>
	</div>
    
	<div class="mws-panel-body">
		<div class="createMwsForm">
			<?php echo $form; ?>
		</div>
	</div>
	
	<?php if ($page->getParam('isCaseStudy') && ! $page->getParam('videoList')): ?>
	<div class="mws-panel-header">
		<span>
			<i class="icon-list"></i>
			Videos
		</span>
		
	</div>
	<div class="mws-panel-body">
		<div class="mws-form">
			<div class="mws-form-row">
				<label class="mws-form-label">Videos</label>
				<div class="mws-form-item" id="attachedVideos" data-id="<?php echo $form->model->id ?>">
					
				</div>
			</div>
		</div>
	</div>

	
	<?php endif; ?>
</div>
