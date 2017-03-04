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
