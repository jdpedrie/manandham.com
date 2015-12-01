<?php

use Phinx\Migration\AbstractMigration;

class Guests extends AbstractMigration
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
        $guests = $this->table('guests');
        $guests->addColumn('firstName', 'string', array('limit' => 100))
              ->addColumn('lastName', 'string', array('limit' => 100))
              ->addColumn('emailAddress', 'string', array('limit' => 100))
              ->addColumn('phoneNumber', 'decimal', array('limit' => 10))
              ->addColumn('address', 'string', array('limit' => 255))
              ->create();
    }
}
