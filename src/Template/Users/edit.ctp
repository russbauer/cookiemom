
<?php use Cake\Core\Configure; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link(__('Users'), ['controller'=>'users', 'action' => 'index'])?></li>
    <li class="breadcrumb-item active" aria-current="page"><?= ($userId) ? "Edit User" : "Add User"?></li>
  </ol>
</nav>

<div class="users form">
<?= $this->Form->create($user) ?>
  <div class="card" style="width: 40rem;">
    <div class="card-body">
          <div class="form-group">
                <?= $this->Form->control('username', ['class' => 'form-control']) ?>
          </div>
          
          <div class="form-group">
              <?= $this->Form->control('first_name', ['class' => 'form-control']) ?>
          </div>

          <div class="form-group">
            <?= $this->Form->control('last_name', ['class' => 'form-control']) ?>
          </div>

          <div class="form-group">
            <?= $this->Form->control('email', ['class' => 'form-control']) ?>
          </div>

          <div class="form-group">
            <?= $this->Form->control('access_level', ['class' => 'form-control', 'options' => Configure::read('AuthRolesList')]) ?>
          </div>

          <div class="form-group">
            <?= $this->Form->control('password1', ['label' => 'Password', 'type' => 'password', 'class' => 'form-control']) ?>
          </div>

          <div class="form-group">
            <?= $this->Form->control('password2', ['label' => 'Confirm Password', 'type' => 'password', 'class' => 'form-control']) ?>
          </div>
          
          <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-outline-primary float-right']); ?>
        </div>
  </div>
<?= $this->Form->end() ?>
</div>