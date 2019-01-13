

<h2><?= __('Cookies') ?></h2>
<div style="width: 80em">
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= __('Actions') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cookies as $cookie): ?>
            <tr>
               <td>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cookie->id])?> | 
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cookie->id], ['confirm' => __('Are you sure you want to delete permamently {0}?', $cookie->name)]) ?>
                </td>
                <td><?= $cookie->name ?></td>
                <td>$<?= $cookie->price ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<br/>
<?= $this->Html->link(__('<button type="button" class="btn btn-primary">Add Cookie</button>'), ['action' => 'edit'], ['escape' => false]) ?>