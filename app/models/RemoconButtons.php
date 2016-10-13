<?php

class RemoconButtons extends \Phalcon\Mvc\Model
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

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $remocon_id;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    public $ir_data;

    /**
     * 赤外線情報送信
     *
     * @return string
     */
    public function send()
    {
        echo 'send ir : ' . base64_encode($this->ir_data);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'remocon_buttons';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RemoconButtons[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RemoconButtons
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
