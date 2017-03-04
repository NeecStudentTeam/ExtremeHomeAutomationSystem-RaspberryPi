<?php

class ApplianceRemocons extends \Phalcon\Mvc\Model
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
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $remocon_id;

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
        
        $this->belongsTo(
            "remocon_id",
            "Remocons",
            "id",
            array(
              "alias" => "remocon"
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
        return 'appliance_remocons';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ApplianceRemocons[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ApplianceRemocons
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
