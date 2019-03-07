<?= $this->Form->create() ?>
<?= $this->Form->control("user_id", [ 'type' => 'hidden', 'default' => $user->id]); ?>

<table class="table table-striped">
<thead>
    <tr>
        <th><?= __('Actions') ?></th>
        <th><?= $this->Paginator->sort('Cookie') ?></th>
        <th><?= $this->Paginator->sort('Quantity') ?></th>
    </tr>
</thead>
<tbody>
    <?php 
    $total = 0;
    foreach ($cookies as $cookie) : 
        if (!isset($orders[$cookie->id])) continue; ?>
        <tr>
            <td>
                <input type="checkbox"/>
            </td>
            <td><?= $cookie->name ?></td>
            <td><?= $orders[$cookie->id] ?></td>
        </tr>
    <?php 
        $total += $orders[$cookie->id];
        endforeach; 
    ?>
    <tr class="table-info">
        <td colspan="3">
        Total Boxes = <?= $total ?><br/>
        Digital Orders = <?= $digitalCount ?><br/>

        Total Due = <?= "({$total} - {$digitalCount}) * $5" ?> = <b><?= ($total - $digitalCount) * 5 ?></b>
        <?= $this->Form->control("totalCookies", [ 'type' => 'hidden', 'default' => $total]); ?>
        <?= $this->Form->control("totalMoney", [ 'type' => 'hidden', 'default' => $total * 5]); ?>
        </td>
    </tr>
</tbody>
</table>
<br/><br/>
<button class="btn btn-primary">Agree and Complete Pickup</button>
<br/><br/><br/>
<?= $this->Form->end() ?>