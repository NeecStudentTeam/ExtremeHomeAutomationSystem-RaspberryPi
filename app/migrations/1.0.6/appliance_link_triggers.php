<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class ApplianceLinkTriggersMigration_106
 */
class ApplianceLinkTriggersMigration_106 extends Migration
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
        self::$_connection->insert(
        "appliance_link_triggers",
        array(1, "ONになったら"),
        array("id", "name")
        );self::$_connection->insert(
        "appliance_link_triggers",
        array(2, "OFFになったら"),
        array("id", "name")
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
