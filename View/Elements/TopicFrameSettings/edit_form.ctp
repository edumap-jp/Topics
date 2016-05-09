<?php
/**
 * 表示方法変更element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('TopicFrameSetting.id'); ?>
<?php echo $this->NetCommonsForm->hidden('TopicFrameSetting.frame_key'); ?>

<?php
	$displayTypeDomId = $this->NetCommonsForm->domId('TopicFrameSetting.display_type');
	$selectRoomDomId = $this->NetCommonsForm->domId('TopicFrameSetting.select_room');
	$selectPluginDomId = $this->NetCommonsForm->domId('TopicFrameSetting.select_plugin');
	$selectBlockDomId = $this->NetCommonsForm->domId('TopicFrameSetting.select_block');
	$rssFeedDomId = $this->NetCommonsForm->domId('TopicFrameSetting.use_rss_feed');

	$ngInit = $displayTypeDomId . ' = ' . (int)Hash::get($this->request->data, 'TopicFrameSetting.display_type', '0') . '; ' .
			$selectRoomDomId . ' = ' . (int)Hash::get($this->request->data, 'TopicFrameSetting.select_room') . '; ' .
			$selectPluginDomId . ' = ' . (int)Hash::get($this->request->data, 'TopicFrameSetting.select_plugin') . '; ' .
			$selectBlockDomId . ' = ' . (int)Hash::get($this->request->data, 'TopicFrameSetting.select_block') . '; ' .
			$rssFeedDomId . ' = ' . (int)Hash::get($this->request->data, 'TopicFrameSetting.use_rss_feed') . ';';
?>

<div ng-init="<?php echo $ngInit; ?>">
	<div class="row form-group">
		<div class="col-xs-12 text-nowrap">
			<?php echo $this->NetCommonsForm->radio('TopicFrameSetting.unit_type',
					array(TopicFrameSetting::UNIT_TYPE_DAYS => __d('topics', 'Show the information for past xx days.')),
					array(
						'legend' => false,
						'ng-click' => 'clickUnitType($event)',
					)
				); ?>
		</div>
		<div class="col-xs-11 col-xs-offset-1">
			<?php echo $this->NetCommonsForm->selectDays('TopicFrameSetting.display_days', array(
				'div' => false,
			)); ?>
		</div>
	</div>

	<div class="row form-group">
		<div class="col-xs-12 text-nowrap">
			<?php echo $this->NetCommonsForm->radio('TopicFrameSetting.unit_type',
					array(TopicFrameSetting::UNIT_TYPE_NUMBERS => __d('topics', 'View number.')),
					array(
						'legend' => false,
						'ng-click' => 'clickUnitType($event)',
					)
				); ?>
		</div>
		<div class="col-sm-11 col-xs-offset-1">
			<?php echo $this->NetCommonsForm->selectNumber('TopicFrameSetting.display_number', array(
				'div' => false,
			)); ?>
		</div>
	</div>

	<?php
		echo $this->NetCommonsForm->input('TopicFrameSetting.display_type', array(
			'type' => 'select',
			'options' => array(
				TopicFrameSetting::DISPLAY_TYPE_FLAT => __d('topics', 'Show flat'),
				TopicFrameSetting::DISPLAY_TYPE_PLUGIN => __d('topics', 'Sorted by plugins'),
				TopicFrameSetting::DISPLAY_TYPE_ROOMS => __d('topics', 'Sorted by rooms'),
			),
			'label' => __d('topics', 'Display type'),
			//'ng-model' => $displayTypeDomId,
			'ng-click' => $displayTypeDomId . ' = selected($event);',
		));
	?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo __d('topics', 'Display items'); ?>
		</div>

		<div class="panel-body clearfix topics-display">
			<?php
				echo $this->NetCommonsForm->input('TopicFrameSetting.display_title', array(
					'type' => 'checkbox',
					'label' => __d('topics', 'Title'),
					'disabled' => true,
				));
			?>
			<?php
				echo $this->NetCommonsForm->input('TopicFrameSetting.display_summary', array(
					'type' => 'checkbox',
					'label' => __d('topics', 'Detail'),
				));
			?>
			<?php
				echo $this->NetCommonsForm->input('TopicFrameSetting.display_room_name', array(
					'type' => 'checkbox',
					'label' => __d('topics', 'Room name'),
					'ng-disabled' => $displayTypeDomId . ' === ' . TopicFrameSetting::DISPLAY_TYPE_ROOMS,
				));
			?>
			<?php
				echo $this->NetCommonsForm->input('TopicFrameSetting.display_plugin_name', array(
					'type' => 'checkbox',
					'label' => __d('topics', 'Plugin name'),
					'ng-disabled' => $displayTypeDomId . ' === ' . TopicFrameSetting::DISPLAY_TYPE_PLUGIN,
				));
			?>
			<?php
				echo $this->NetCommonsForm->input('TopicFrameSetting.display_created_user', array(
					'type' => 'checkbox',
					'label' => __d('topics', 'Creator'),
				));
			?>
			<?php
				echo $this->NetCommonsForm->input('TopicFrameSetting.display_created', array(
					'type' => 'checkbox',
					'label' => __d('topics', 'Creation datetime'),
				));
			?>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<?php
				echo $this->NetCommonsForm->input('TopicFrameSetting.select_room', array(
					'type' => 'checkbox',
					'label' => __d('topics', 'Select room to show'),
					'div' => 'form-inline',
					'ng-checked' => $selectRoomDomId,
					'ng-click' => $selectRoomDomId . ' = checked($event); ' . $selectBlockDomId . ' = 0;',
				));
			?>
		</div>

		<div class="panel-body" ng-show="<?php echo $selectRoomDomId; ?>">
			<div class="topics-frame-rooms">
				<?php
					echo $this->RoomsForm->checkboxRooms(
						'TopicFramesRoom.room_id',
						array(
							'privateSpace' => false,
							'default' => Hash::get($this->request->data, 'TopicFramesRoom.room_id'),
						)
					);
				?>
			</div>
			<hr>
			<?php
				echo $this->NetCommonsForm->input('TopicFrameSetting.show_my_room', array(
					'type' => 'checkbox',
					'label' => __d('topics', 'Display my room as new arrival.'),
					'div' => false
				));
			?>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<?php
				echo $this->NetCommonsForm->input('TopicFrameSetting.select_plugin', array(
					'type' => 'checkbox',
					'label' => __d('topics', 'Select plugin to show'),
					'class' => false,
					'div' => 'form-inline',
					'ng-checked' => $selectPluginDomId,
					'ng-click' => $selectPluginDomId . ' = checked($event); ' . $selectBlockDomId . ' = 0;',
				));
			?>
		</div>

		<div class="panel-body" ng-show="<?php echo $selectPluginDomId; ?>">
			<div class="form-inline">
				<div class="clearfix">
					<?php
						echo $this->PluginsForm->checkboxPluginsRoom(
							'TopicFramesPlugin.plugin_key',
							array(
								'div' => array('class' => 'plugin-checkbox-outer'),
								'default' => Hash::get($this->request->data, 'TopicFramesPlugin.plugin_key'),
							)
						);
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<?php
				echo $this->NetCommonsForm->input('TopicFrameSetting.select_block', array(
					'type' => 'checkbox',
					'label' => __d('topics', 'Select block to show'),
					'div' => 'form-inline',
					'ng-checked' => $selectBlockDomId,
					'ng-click' => $selectBlockDomId . ' = checked($event); ' . $selectRoomDomId . ' = 0;' . $selectPluginDomId . ' = 0;',
				));
			?>
		</div>

		<div class="panel-body" ng-show="<?php echo $selectBlockDomId; ?>">
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<?php
				echo $this->NetCommonsForm->input('TopicFrameSetting.use_rss_feed', array(
					'type' => 'checkbox',
					'label' => __d('topics', 'RSS feed'),
					'class' => false,
					'div' => false,
					'childDiv' => array('class' => 'form-inline'),
					'ng-click' => $rssFeedDomId . ' = checked($event)',
				));
			?>
		</div>

		<div class="panel-body" ng-show="<?php echo $rssFeedDomId; ?>">
			<?php echo $this->NetCommonsForm->input('TopicFrameSetting.feed_title', array(
					'label' => __d('topics', 'Feed title'),
				)); ?>

			<?php echo $this->NetCommonsForm->input('TopicFrameSetting.feed_summary', array(
					'type' => 'textarea',
					'label' => __d('topics', 'Feed summary'),
					'help' => $this->Topics->rssSettingHelp(__d('topics', '{X-SITE_NAME} : Site name'))
				)); ?>
		</div>
	</div>
</div>