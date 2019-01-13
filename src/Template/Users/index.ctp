
<nav class="navbar navbar-default">
    <ul class="nav navbar-nav">
        <li><?= $this->Html->link(__('<button type="button" class="btn btn-primary">Add User</button>'), ['action' => 'edit'], ['escape' => false]) ?></li>
    </ul>
</nav>
<div class="card" style="width: 80em">
    <h3><?= __('Users') ?></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= __('Actions') ?></th>
                <th><?= $this->Paginator->sort('ID') ?></th>
                <th><?= $this->Paginator->sort('Status') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('access') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
               <td>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id])?> | 
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete permamently {0}?', $user->username)]) ?>
                </td>
                <td><?= h($user->id) ?></td>
                <td><?= ($user->active) ? "Active" : "Disabled" ?></td>
                <td><?= h($user->first_name) . ' ' . h($user->last_name)?></td>
                <td><?= h($user->email) ?></td>
                <td><?php switch ($user->access_level) {
                    case 90: 
                        echo "Leader"; 
                        break;
                    case 60:
                        echo "Member"; 
                        break;
                    case 20:
                        echo "Cookie Booth"; 
                        break;
                    default: 
                        echo "Unknown"; 
                        break;
                } ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>