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
    protected $status;

    /**
     * Method to set the value of field value
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        $status_arr = json_decode($status,true);

        switch($this->name) {
          case "power":
            // 設定されてる連動設定を全て取得
            // 連動をする
            // 指定された家電の電源をオンにするボタンを押す
            break;
        }

        return $this;
    }

    /**
     * Returns the value of field value
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
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
