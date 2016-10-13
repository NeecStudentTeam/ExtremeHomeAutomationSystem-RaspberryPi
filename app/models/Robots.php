<?php

class Robots extends \Phalcon\Mvc\Model
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
     * @Column(type="integer", length=11, nullable=true)
     */
    public $robot_id;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=true)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $created_at;

    public function initialize()
    {
        $this->hasOne("robot_id", "Robots", "id", array(
            "alias" => "robot"
        ));
        $this->belongsTo("robot_id", "Robots", "id", array(
            "alias" => "child_robots"
        ));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'robots';
    }

    public function test()
    {
      echo "test";
      echo json_encode($this->child_robots);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Robots[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Robots
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
