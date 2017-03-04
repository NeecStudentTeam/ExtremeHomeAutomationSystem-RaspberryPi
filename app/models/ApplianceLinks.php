<?php

class ApplianceLinks extends \Phalcon\Mvc\Model
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
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $appliance_link_set_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $trigger_appliance_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $trigger_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $action_appliance_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $action_id;
    
    public function initialize()
    {
      $this->belongsTo(
          "appliance_link_set_id",
          "ApplianceLinkSets",
          "id",
          array(
            "alias" => "appliance_link_set"
          )
      );
      
      $this->belongsTo(
          "trigger_appliance_id",
          "Appliances",
          "id",
          array(
            "alias" => "trigger_appliance"
          )
        );
      );
      
      $this->belongsTo(
          "trigger_id",
          "ApplianceLinkTriggers",
          "id",
          array(
            "alias" => "appliance_link_trigger"
          )
      );
    
      $this->belongsTo(
          "action_appliance_id",
          "Appliances",
          "id",
          array(
            "alias" => "action_appliance"
          )
      );
      
      $this->belongsTo(
          "action_id",
          "ApplianceLinkActions",
          "id",
          array(
            "alias" => "appliance_link_action"
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
        return 'appliance_links';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ApplianceLinks[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ApplianceLinks
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
