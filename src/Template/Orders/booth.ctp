
<?php use Cake\Core\Configure; ?>

<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><?= $this->Html->link(__('Orders'), ['controller'=>'orders', 'action' => 'index'])?></li>
    <li class="breadcrumb-item active" aria-current="page">Cookie Booth Order</li>
</ol>
</nav>

<h1>Cookie Booth Order Form</h1>
<div id="boothOrderApp" class="cookie form" style="margin-right: 4em;">
    <?= $this->Form->create() ?>
    <?= $this->Form->input("user_id", [ 'type' => 'hidden', 'default' => $user->id]); ?>

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
            foreach ($cookies as $cookie) : 
                if ($cookie->not_for_delivery) continue; ?>
        <tr>
            <th scope="row">
            <?= $cookie->name ?><br/>
            <i style="font-weight: normal;">
                Cases: <?= (int) ($orders[$cookie->id] / $cookie->boxes_per_case)  ?>, 
                Boxes till next case: <?= $cookie->boxes_per_case - ($orders[$cookie->id] % $cookie->boxes_per_case)?>
            </i>
            <?= $this->Form->control("order[" . $i . "].cookie_id", [ 'type' => 'hidden', 'default' => $cookie->id]); ?>
            <?= $this->Form->control("order[" . $i . "].cookie_name", [ 'type' => 'hidden', 'default' => $cookie->name]); ?>
            </th>
            <td>
            <?= $this->Form->control("order[" . $i . "].quantity", 
            ['label' => false, 
            'required' => true, 
            'type' => 'number', 
            'style' => 'margin-top: 6px;',
            'v-model' => "orders[{$i}].quantity"]); ?>
            </td>
        </tr>
        <?php 
            $i++; endforeach; ?>
        </tbody>
    </table>
    <button class="btn btn-outline-primary float-right">Submit</button>
<?= $this->Form->end() ?>
</div>