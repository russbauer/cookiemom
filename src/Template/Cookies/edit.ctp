
<?php use Cake\Core\Configure; ?>
<script>
$( function() {

});
</script>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link(__('Cookies'), ['controller'=>'cookies', 'action' => 'index'])?></li>
    <li class="breadcrumb-item active" aria-current="page"><?= ($cookieId) ? "Edit Cookie" : "Add Cookie"?></li>
  </ol>
</nav>

<div class="cookie form">
<?= $this->Form->create($cookie) ?>
  <div class="card" style="width: 40rem;">
    <div class="card-body">
          <div class="form-group">
                <?= $this->Form->input('name', ['class' => 'form-control']) ?>
          </div>

          <div class="form-group">
            <?= $this->Form->input('price', ['class' => 'form-control']) ?>
          </div>

          <div class="form-group">
              <?= $this->Form->input('boxes_per_case', ['class' => 'form-control']) ?>
          </div>

          <div class="form-group">
              <?= $this->Form->input('not_for_delivery', ['class' => 'form-control']) ?>
          </div>

          <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-outline-primary float-right']); ?>
        </div>
  </div>
<?= $this->Form->end() ?>
</div>