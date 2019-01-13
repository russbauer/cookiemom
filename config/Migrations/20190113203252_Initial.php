<?php
use Migrations\AbstractMigration;
use Cake\ORM\TableRegistry;

class Initial extends AbstractMigration
{
    public function up()
    {

        $this->table('cookies')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('price', 'decimal', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('not_for_delivery', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('boxes_per_case', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(
                [
                    'name',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('orders')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('cookie_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('quantity', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('digital', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('users')
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 32,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('first_name', 'string', [
                'default' => '',
                'limit' => 64,
                'null' => false,
            ])
            ->addColumn('last_name', 'string', [
                'default' => '',
                'limit' => 64,
                'null' => false,
            ])
            ->addColumn('phone', 'string', [
                'default' => null,
                'limit' => 64,
                'null' => true,
            ])
            ->addColumn('locked', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('reset_token', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('reset_time', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('language', 'string', [
                'default' => 'en',
                'limit' => 8,
                'null' => false,
            ])
            ->addColumn('country', 'string', [
                'default' => 'us',
                'limit' => 8,
                'null' => false,
            ])
            ->addColumn('last_login', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 64,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('active', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('access_level', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('order_token', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addIndex(
                [
                    'email',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'username',
                ],
                ['unique' => true]
            )
            ->create();

        // Save records to the newly created schema
        $usersTable = TableRegistry::get('Users');
        $user = $usersTable->newEntity();

        $user->first_name = 'Cookie';
        $user->last_name = 'Mom';
        $user->email = 'tcm@changethisemailsoon.com';
        $user->username = 'admin';
        $user->password = "passwd";
        $user->access_level = 90;
        $usersTable->save($user, ['atomic' => false]);
    }

    public function down()
    {
        $this->table('cookies')->drop()->save();
        $this->table('orders')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
