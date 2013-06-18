<?php $this->beginContent('//layouts/layout-admin'); ?>

		<div id="leftContent">
				
				<?php
				$this->widget('backend.widgets.menu.WidgetMenu')
				?>
				
			</div>
			<div id="rightContent">
				<?php echo $content; ?>
			</div>
<?php $this->endContent(); ?>