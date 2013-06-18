<div>
		<div><a href="#" class="editRecord" data-id="0"> Create new item </a></div>
	
</div>
	<ul class="contentList list">
		<?php foreach ($contents as $content): ?>
		<li>
			<div class="left">
				<?php echo CHtml::link( $content->label, '#', array('data-id' => $content->id, 'class' => 'editRecord')  ); ?>
			</div>
			<div class="buttons" data-id="<?php echo $content->id ?>">
				<a class="icon delete"></a>
			</div>
		</li>
		<?php endforeach;?>
	</ul>