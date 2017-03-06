<?php

class Remocons extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
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
          "remocon_id", "appliance_id",
          "Appliances",
          "id",
          array(
              "alias" => "appliances"
          )
      );
      $this->hasMany("id", "RemoconButtons", "remocon_id", array(
          "alias" => "remocon_buttons"
      ));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'remocons';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Remocons[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Remocons
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
