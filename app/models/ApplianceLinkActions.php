<?php

class ApplianceLinkActions extends \Phalcon\Mvc\Model
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
     * @Column(type="string", length=255, nullable=false)
     */
    public $name;
    
    public function initialize()
    {
      $this->hasMany("id", "ApplianceLinks", "action_id", array(
          "alias" => "appliance_links"
      ));
    }
    
    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'appliance_link_actions';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ApplianceLinkActions[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ApplianceLinkActions
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
