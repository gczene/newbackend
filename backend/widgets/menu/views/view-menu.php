


        <!-- Sidebar Wrapper -->
        <div id="mws-sidebar">
        
            <!-- Hidden Nav Collapse Button -->
            <div id="mws-nav-collapse">
                <span></span>
                <span></span>
                <span></span>
            </div>
			
			
	<?php /** / ?>
	<!-- Searchbox -->
	<div id="mws-searchbox" class="mws-inset">
		<form action="typography.html">
			<input type="text" class="mws-search-input" placeholder="Search...">
			<button type="submit" class="mws-search-submit"><i class="icon-search"></i></button>
		</form>
	</div>
	<?php /**/ ?>
			
            <!-- Main Navigation -->
            <div id="mws-navigation">
		<ul>
		<?php foreach($places as $place): ?>
		<li class=""><a href="#"><i class="icon-chevron-right"></i> <?php echo $place->label ?></a>
			<ul>
				<?php foreach($place->pages as $page): ?>
				<li>
						<?php echo CHtml::link(  ($page->parent ? $page->parent->label . ' - ' . $page->label : $page->label ) , Yii::app()->createUrl('/admin/page/' . $page->id) ) ; ?>
				</li>
				<?php endforeach;?>				
				
			</ul>
					
		</li>
		<?php endforeach; ?>
		<li>	
			<a href="<?php echo Yii::app()->createUrl('admin/newsletter') ?>" target="_blank">
				<i class="icon-list-2"></i> Newsletter subscriptions
			</a>
		</li>
		<li>	
			<a href="<?php echo Yii::app()->createUrl('admin/youtubeCSV') ?>" target="_blank">
				<i class="icon-list-2"></i> YouYube
			</a>
		</li>
		<li>	
			<a href="<?php echo Yii::app()->createUrl('admin/seo') ?>">
				<i class="icon-sign-post"></i> Seo
			</a>
		</li>
		<li>	
			<a href="<?php echo Yii::app()->createUrl('admin/users') ?>">
				<i class="icon-users"></i> Accounts
			</a>
		</li>
		<li>	
			<a href="<?php echo Yii::app()->createUrl('admin/backgrounds') ?>">
				<i class="icon-file-zip"></i> Page Backgrounds
			</a>
		</li>
		<li>	
			<a href="<?php echo Yii::app()->createUrl('admin/logout') ?>">
				<i class="icon-unlink"></i> Logout
			</a>
		</li>
		</ul>				
            </div>         
        </div>

