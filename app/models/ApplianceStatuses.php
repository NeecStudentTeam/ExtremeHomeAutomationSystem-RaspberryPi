<?php

class ApplianceStatuses extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $appliance_id;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=true)
     */
    public $status;


    public function initialize()
    {
      $this->belongsTo(
          "appliance_id",
          "Appliances",
          "id",
          array(
            "alias" => "appliance"
          )
      );
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'appliance_statuses';
    }
    public function afterSave()
    {
        // ステータス変動時のイベント処理
        $appliance_links = ApplianceLinks::find("trigger_appliance_id = " . $this->appliance->id);
        foreach($appliance_links as $appliance_link) {
          if($appliance_link->appliance_link_set->status == 0) continue;
          if( ($this->name == "power" && $appliance_link->trigger_id == 1 && $this->status == "on") ||
              ($this->name == "power" && $appliance_link->trigger_id == 2 && $this->status == "off")) {
                switch($appliance_link->action_id) {
                  case 1:
                      $appliance_link->action_appliance->powerOn();
                    break;
                  case 2:
                      $appliance_link->action_appliance->powerOff();
                    break;
                  case 3:
                      $appliance_link->action_appliance->pushPowerButton();
                    break;
                }
          }
        }
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ApplianceStatuses[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ApplianceStatuses
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
