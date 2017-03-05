<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class ApplianceLinkActionsMigration_106
 */
class ApplianceLinkActionsMigration_106 extends Migration
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
        "appliance_link_actions",
        array(1, "ONにする"),
        array("id", "name")
        );
        self::$_connection->insert(
        "appliance_link_actions",
        array(2, "OFFにする"),
        array("id", "name")
        );
        self::$_connection->insert(
        "appliance_link_actions",
        array(3, "ONとOFFを切り替え"),
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
