

<?php use Cake\Core\Configure; ?>

<h2>Orders</h2>
<div class="accordion" id="accordionOrders" style="width:90%;">
<?php foreach ($users as $key => $user): ?>

    <div class="card">
        <div class="card-header 
            <?php 
            if ($user->pickup_confirmed) {
                echo "bg-info"; 
            } else if ($user->orders) {
                echo "bg-success";
            } else {
                echo "bg-secondary"; } ?>" id="heading<?= $key ?>">
                
            <h5 class="mb-0">
                <button style="width: 100%; text-align: left;" class="btn btn-link collapsed text-white" type="button" data-toggle="collapse" data-target="#collapse<?= $key ?>" aria-expanded="false" aria-controls="collapse<?= $key ?>">
                <?= "{$user->first_name}  {$user->last_name}" ?>
                </button>
            </h5>
        </div>

        <div id="collapse<?= $key ?>" class="collapse" aria-labelledby="heading<?= $key ?>" data-parent="#accordionOrders">
        <div class="card-body">
        <?php if ($user->orders) : ?>
            <table class="table table-striped">
            <thead>
                <tr>
                    <th><?= __('Actions') ?></th>
                    <th><?= $this->Paginator->sort('Cookie') ?></th>
                    <th><?= $this->Paginator->sort('Quantity') ?></th>
                    <th><?= $this->Paginator->sort('Created') ?></th>
                    <th><?= $this->Paginator->sort('Digital') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user->orders as $order) :?>
                <tr>
                    <td>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete permamently {0}?', $order->id)]) ?>
                    </td>
                    <td><?= $order->cookie->name ?></td>
                    <td><?= $order->quantity ?></td>
                    <td><?= $order->created ?></td>
                    <td><?= $order->digital ? "Yes" : "No" ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
            <hr/>
            <?php else:?> 
                <i>No orders found</i><br/><br/>
            <?php endif;?>
            
            <p>
            <?php if ($user->access_level == Configure::read('AuthRoles.booth')) : ?>
                <?= $this->Html->link(__('Add Booth Order'), ['action' => 'booth', $user->id]) ?> | 
                <?= $this->Html->link(__('Inventory Totals'), ['action' => 'inventory', $user->id]) ?>
            <?php else : ?>
                <?= $this->Html->link(__('Request Order'), 
                ['action' => 'request', $user->id], 
                ['confirm' => __("Remove all existing orders and send an order request to {$user->first_name} at '{$user->email}'?")]) ?>
                
                |

                <?= $this->Html->link(__('Add To Order'), ['action' => 'add', $user->id]) ?> | 
                <?= $this->Html->link(__('Confirm Pickup'), ['action' => 'pickup', $user->id]) ?>
            <?php endif;?>
            </p>
        </div>
    </div>
</div>
<?php endforeach; ?>
</div>
<br/><br/><br/>