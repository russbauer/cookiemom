<?= $this->Form->create() ?>
<?= $this->Form->control("user_id", [ 'type' => 'hidden', 'default' => $user->id]); ?>

<table class="table table-striped">
<thead>
    <tr>
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
            <td><?= $cookie->name ?></td>
            <td><?= $orders[$cookie->id] ?></td>
        </tr>
    <?php 
        $total += $orders[$cookie->id];
        endforeach; 
    ?>
    <tr class="table-info">
        <td colspan="3">
        Total = <b>$<?= $total * 5 ?></b>
        </td>
    </tr>
</tbody>
</table>
<br/><br/>
<?= $this->Form->end() ?>