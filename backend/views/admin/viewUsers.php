<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span>
			<i class="icon-users"></i>
			Manage Users</span>
		
	</div>
		<div class="mws-panel-toolbar">
			<div class="btn-toolbar">
				<div class="btn-group">
					<a href="<?php echo Yii::app()->createUrl('admin/user_form/0'); ?>" class="btn"><i class="icol-add"></i> Add New User</a>
				</div>
			</div>

		</div>	
	<div class="mws-panel-body">
		
		<table class="mws-table mws-datatable-fn lastIs30">
			<thead>
				<th>E-mail</th>
				<th>Name</th>
				<th></th>
			</thead>
			<tbody>
				<?php foreach($users as $user): ?>
					<tr>
						<td><?php echo $user->email ?></td>
						<td><?php echo $user->name ?></td>
						<td><a title="Edit user" href="<?php echo Yii::app()->createUrl('admin/user_form/' . $user->id) ?>"  class="icol-pencil"></a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>