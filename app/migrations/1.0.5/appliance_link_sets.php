<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class ApplianceLinkSetsMigration_105
 */
class ApplianceLinkSetsMigration_105 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
      
      
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {
        self::$_connection->dropTable('appliance_link_sets');
          $this->morphTable('appliance_link_sets', [
                  'columns' => [
                      new Column(
                          'id',
                          [
                              'type' => Column::TYPE_INTEGER,
                              'notNull' => true,
                              'autoIncrement' => true,
                              'size' => 11,
                              'first' => true
                          ]
                      ),
                      new Column(
                          'name',
                          [
                              'type' => Column::TYPE_VARCHAR,
                              'notNull' => true,
                              'size' => 255,
                              'after' => 'id'
                          ]
                      ),
                      new Column(
                          'status',
                          [
                              'type' => Column::TYPE_INTEGER,
                              'notNull' => true,
                              'size' => 11,
                              'after' => 'name'
                          ]
                      )
                  ],
                  'indexes' => [
                      new Index('PRIMARY', ['id'], 'PRIMARY')
                  ],
                  'options' => [
                      'TABLE_TYPE' => 'BASE TABLE',
                      'AUTO_INCREMENT' => '1',
                      'ENGINE' => 'InnoDB',
                      'TABLE_COLLATION' => 'utf8_general_ci'
                  ],
              ]
          );
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
