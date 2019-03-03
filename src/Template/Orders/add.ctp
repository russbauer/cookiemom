
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><?= $this->Html->link(__('Orders'), ['controller'=>'orders', 'action' => 'index'])?></li>
      <li class="breadcrumb-item active" aria-current="page">Add Cookie</li>
    </ol>
  </nav>


<h1>Add To Order</h1>
  <?= $this->Form->create() ?>
  <?= $this->Form->control("user_id", [ 'type' => 'hidden', 'default' => $user->id]); ?>

      <table class="table table-striped">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Cookie</th>
            <th scope="col">Quantity</th>
          </tr>
        </thead>
        <tbody>
        <?php 
          $i = 0; 
          foreach ($cookies as $cookie) : ?>
        <tr>
          <th scope="row">
            <?= $cookie->name ?>
            <?= $this->Form->control("order[" . $i . "].cookie_id", ['type' => 'hidden', 'default' => $cookie->id]); ?>
            <?= $this->Form->control("order[" . $i . "].cookie_name", [ 'type' => 'hidden', 'default' => $cookie->name]); ?>
          </th>
          <td>
          <?= $this->Form->control("order[" . $i . "].quantity", 
            ['label' => false, 'type' => 'number']); ?>
          </td>
        </tr>
        <?php 
            $i++; endforeach; ?>
        </tbody>
      </table>
<button class="btn btn-outline-primary">Add</button>
<?= $this->Form->end() ?>