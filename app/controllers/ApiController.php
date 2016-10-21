<?php
/*
/HTTPステータスコード及びヘッダーについては以下を参照
/http://qiita.com/uenosy/items/ba9dbc70781bddc4a491
/
/
/
*/
class ApiController extends ControllerBase
{
  // モデルの取得
  // GET /api/models
  // GET /api/models/1
  // GET /api/models/1/child_model
  // GET /api/models/1/buttons
  // GET /api/models/1/buttons/1
  // モデルのメソッド実行
  // GET /api/models/1/send
  // model1->send();
  // モデルのスタティックメソッドにモデル一覧を渡して実行
  // GET /api/models/deletes
  // $models =  Model.find();
  // Model->deletes($models);
  public function getEndpointAction(...$params)
  {
    $tmp_params = $params;
    $param = ucfirst(MyLib::camelize(array_shift($tmp_params)));
    $function_result = null;
    $model = null;
    $models = $param::find();
    while(count($tmp_params) > 0)
    {
      $param = array_shift($tmp_params);

      // 一意のmodelが取得されていた場合
      if($model) {
        // パラメータの名前のメソッドがあったら実行
        if(method_exists($model,$param)) {
            $function_result = $model->$param();
            $model = null;
        }
        // パラメータの名前のプロパティがあったら取得
        else if(isset($model->{$param}) || property_exists($model,$param)) {
          // プロパティを取得
          $property = $model->{$param};
          // プロパティが配列の場合、modelsを更新
          if($property instanceof ArrayAccess || is_array($property)) {
            // 自身に追加
            $this->add_model_this($model, true);
            // modelsを更新
            $models = $property;
            $model = null;
          }
          // 一意の場合、modelを更新
          else
          {
            // 自身に追加
            $this->add_model_this($model, false);
            $model = $property;
            // modelを更新
            $model = $property;
            $models = null;
          }
        }
        // 見つからないエラー
        else {
          echo "プロパティもメソッドも見つからないよ : " . $param;
          $model = null;
          $models = null;
        }

        continue;
      }

      // 複数のmodelが取得されていた場合
      if($models) {
        // パラメータが数値だった場合、それをIDとして一意のモデルを取得
        if(is_numeric($param)) {
          // 一意のモデル取得
          $model = null;
          foreach ($models as $models_model) {
            if($models_model->id == $param) {
              $model = $models_model;
            }
          }
          // エラー
          if(!$model) {
            echo "指定されたIDのモデルが見つからないよ : " . $param;
          }
          // 自身に追加
          $this->add_model_this($model, true);
          // modelsにnullを設定
          $models = null;
        }
        // パラメータが数値じゃなかった場合、スタティックメソッド名として実行
        else {
          // 未実装
          // modelsにnullを設定
          $models = null;
        }

        continue;
      }
    }

    // 最後にmodels or model or function_resultを出力
    if($model) {
      $this->output_for_json($model);
    }
    else if($models) {
      $this->output_for_json($models);
    } else if($function_result) {
      $this->output_for_json($function_result);
    }
  }

  // POST /api/models
  // モデルの追加
  public function postEndpointAction()
  {
  	  $this->view->disable();
      $this->response->setStatusCode(201, "Created");
      // 適当にLocationをつける
      $this->response->setHeader('Location', '/api/models/15');
  }

  // PUT /api/models/1
  // 指定モデルの更新
  public function putEndpointAction(...$params)
  {
        $model = array(
          'id' => $i,
          'name' => 'TestModel' + $i,
          'created_at' => '2011/01/01 20:00:00'
        );

        $this->response->setStatusCode(204, "No Content");
  }

  // DELETE /api/models/1
  // 指定モデルの削除
  public function deleteEndpointAction(...$params)
  {
  			$this->view->disable();
        $this->response->setStatusCode(204, "No Content");
  }

  // jsonで出力する
  // GETのcallbackパラメータを取得し、json or jsonpを自動で判断する
  // また、出力する際にviewを無効にする
  private function output_for_json($var)
  {
    // viewを無効にする
    $this->view->disable();
    // jsonの文字列を作成
    $json_str = json_encode($var);
    // callbackを取得
    $callback = $this->request->getQuery('callback');
    // jsonpで出力するか否か
    if($callback) {
      // Content-Typeを設定
      $this->response->setHeader("Content-Type", "text/javascript");
      // jsonpで出力
      echo $callback . "(" . $json_str . ")";
    }
    // jsonで出力
    else {
      // Content-Typeを設定
      $this->response->setHeader("Content-Type", "application/json");
      // jsonで出力
      echo $json_str;
    }
  }

  // 自分にモデルを追加する
  // $model_is_arrayをtrueにすると、arrayとして追加する
  private function add_model_this($value, $value_is_array = false)
  {
    if($value_is_array) {
      $model_name = MyLib::underscore(get_class($value));
      $this->$model_name = $value;
    }
    else {
      $model_name = MyLib::singularByPlural(MyLib::underscore(get_class($value)));
      $this->$model_name = $value;
    }
  }
}
