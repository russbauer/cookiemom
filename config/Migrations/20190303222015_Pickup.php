<?php
use Migrations\AbstractMigration;

class Pickup extends AbstractMigration
{

    public function up()
    {

        $this->table('users')
            ->addColumn('pickup_confirmed', 'boolean', [
                'after' => 'order_token',
                'default' => '0',
                'length' => null,
                'null' => false,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('users')
            ->removeColumn('pickup_confirmed')
            ->update();
    }
}

