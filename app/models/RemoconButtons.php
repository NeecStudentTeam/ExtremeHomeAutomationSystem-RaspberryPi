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


    public function initialize()
    {
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
     * 赤外線情報送信
     *
     * @return string
     */
    public function send()
    {
      // ステータスのトグル
      if($this->name == "power") {
        $appliances = $this->remocon->appliances;
        foreach($appliances as $appliance) {
            $status = $appliance->getStatusObj("power");
            if($status) {
              switch($status->status) {
                case "on":
                  $status->status = "off";
                  // echo "send off";
                  break;
                case "off":
                  $status->status = "on";
                  // echo "send on";
                  break;
              }
              $status->save();
            }
        }
      }

      return json_encode(array('output' => InfraredTransmitter::send($this->ir_data)));
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
