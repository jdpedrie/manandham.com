<?php

use Phinx\Migration\AbstractMigration;

class Transactions extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $transactions = $this->table('transactions');
        $transactions->addColumn('guestId', 'integer')
            ->addForeignKey('guestId', 'guests', 'id')
            ->addColumn('stripeTransactionId', 'string', ['limit' => 100])
            ->addColumn('date', 'timestamp')
            ->addColumn('result', 'string', ['limit' => 10])
            ->addColumn('amount', 'integer', ['limit' => 10])
            ->create();
    }
}
