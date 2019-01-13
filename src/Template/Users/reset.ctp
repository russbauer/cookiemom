<h2>
    <?php echo __('Reset Password'); ?>
</h2>
<div class="users form">
<?php echo $this->Form->create(); ?>

    <fieldset>
            <p>
        <?php echo __('Enter your email address to received an email to reset your password.'); ?>
    </p>

        <?php echo $this->Form->input('email'); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
<?php echo $this->Form->end(); ?>
</div>