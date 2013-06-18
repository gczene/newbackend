<div class="mws-panel grid_4">
	<div class="mws-panel-header">
		<span>Pages</span>
	</div>
	<div class="mws-panel-body">
		<table class="mws-table mws-datatable-fn trClick">
			<thead>
				<th>
						dsadsa
				</th>
			</thead>
			<?php foreach($pages as $page): ?>
				<tr data-url="<?php echo Yii::app()->createUrl('admin/seo_edit', array('page_id' => $page->id )) ?>">
					<td><?php echo $page->label ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>