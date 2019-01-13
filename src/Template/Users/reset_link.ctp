
<div class="users form">
<?php echo $this->Form->create(); ?>
	<fieldset>
            <legend><?php echo __('Set New Password'); ?></legend>
            <?php echo __("Enter a new password to reset the account for '") . $user->email?>'<br/><br/>
            <?php
                echo $this->Form->input('password1',array('required' => true, 'type'=>'password', 'label'=>array('text'=>'Password')));
                echo $this->Form->input('password2',array('required' => true, 'type'=>'password', 'label'=>array('text'=>'Confirm password')));
                echo $this->Form->hidden('token', array('default' => $token));
            ?>
	</fieldset>
    <?= $this->Form->button(__('Submit')) ?>
<?php echo $this->Form->end(); ?>
</div>