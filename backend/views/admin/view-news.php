<div>
	<h2><?php echo $page->label; ?></h2>	
	
</div>
<div>
	<?php $this->widget('backend.widgets.contentList.WidgetContentList', 
			array('contents' => $contents, 
				'type' => $page->type, 
				'page' => $page)); ?>

</div>