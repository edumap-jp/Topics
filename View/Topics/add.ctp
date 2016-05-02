<div class="topics form">
<?php echo $this->Form->create('Topic'); ?>
	<fieldset>
		<legend><?php echo __('Add Topic'); ?></legend>
	<?php
		echo $this->Form->input('language_id');
		echo $this->Form->input('room_id');
		echo $this->Form->input('block_id');
		echo $this->Form->input('frame_id');
		echo $this->Form->input('content_id');
		echo $this->Form->input('category_id');
		echo $this->Form->input('plugin_key');
		echo $this->Form->input('title');
		echo $this->Form->input('contents');
		echo $this->Form->input('counts');
		echo $this->Form->input('path');
		echo $this->Form->input('public_type');
		echo $this->Form->input('publish_start');
		echo $this->Form->input('publish_end');
		echo $this->Form->input('is_active');
		echo $this->Form->input('is_latest');
		echo $this->Form->input('status');
		echo $this->Form->input('created_user');
		echo $this->Form->input('modified_user');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Topics'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trackable Creator'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
