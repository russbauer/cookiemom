
<div class="login card">
    <?= $this->Form->create() ?>
    <div class="card-body">
        <h5 class="card-title"><?= __('Login') ?></h5>
        <div class="form-group">
            <?= $this->Form->control('username', ['autocomplete'=>'off', 'class' => 'form-control']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('password', ['class' => 'form-control']) ?>
        </div>
        <?= $this->Html->link(__('Forgot password?'), array('action' => 'reset')); ?>   
        <?= $this->Form->button(__('Login')); ?>
        <?= $this->Form->end() ?>
    </div>
</div>
<br/>
<?= $this->Flash->render() ?>