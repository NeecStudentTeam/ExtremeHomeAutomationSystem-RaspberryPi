<?php

class Appliances extends \Phalcon\Mvc\Model
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
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    public $name;

    public function initialize()
    {
      $this->hasManyToMany(
          "id",
          "ApplianceRemocons",
          "appliance_id", "remocon_id",
          "Remocons",
          "id",
          array(
              "alias" => "remocons"
          )
      );
      $this->hasMany("id", "ApplianceStatuses", "appliance_id", array(
          "alias" => "appliance_statuses"
      ));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'appliances';
    }



    public function pushPowerButton() {
      $remocon = $this->remocons->getFirst();
      foreach ($remocon->remocon_buttons as $button) {
          if($button->name == "power") {
            $button->send();
            break;
          }
      }
    }

    public function powerOn() {
      if($this->getStatus("power") == "off") {
        $this->pushPowerButton();
      }
    }

    public function powerOff() {
      if($this->getStatus("power") == "on") {
        $this->pushPowerButton();
      }
    }

    public function getStatus($status_name) {
      $status = $this->getStatusObj($status_name);
      return $status ? $status->status : null;
    }

    public function getStatusObj($status_name) {
      foreach($this->appliance_statuses as $status) {
        if($status->name == $status_name) {
          return $status;
        }
      }
      return null;
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Appliances[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Appliances
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
