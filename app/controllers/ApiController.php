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
    // 通常のビューテンプレートを無効化
  	$this->view->disable();
    // パラメータからモデル or モデル一覧 or メソッド実行結果を取得
    $result = $this->execute_by_params($params);
    // 取得出来たか
    if($result) {
      // jsonで出力
      $this->output_for_json($result);
      // 正常終了ステータスコード
      $this->response->setStatusCode(200, "OK");
    }
    // エラー　何も取得できなかった（URLが不正）
    else {
      $this->response->setStatusCode(404, "Not Found");
    }
    // クロスドメイン
    $this->response->setHeader('Access-Control-Allow-Origin', '*');
  }

  // POST /api/models
  // モデルの追加
  // /api/robots/1/robot_children/ の場合、robot_childrenのモデルを新しく追加する。 /robots/1/の部分は無視される。
  public function postEndpointAction(...$params)
  {
      // 通常のビューテンプレートを無効化
  	  $this->view->disable();
      // 新しく追加するモデル名を取得
      $model_name = ucfirst(MyLib::camelize(end($params)));
      // 新しく追加するモデルのPOSTデータを取得
      $post_data = $this->request->getJsonRawBody(true);
      // 指定されたモデルが存在するか確認
      if(class_exists($model_name)) {
        // モデルをインスタンス化
        $model = new $model_name();
        // 保存
        if(is_array($post_data) && $model->assign($post_data) && $model->save() == true) {
          // 作成したモデルにアクセスできるURLを返す
          $this->response->setHeader('Location', '/api/' . implode('/',$params) . '/' . $model->id);
          // 正常に終了した
          $this->response->setStatusCode(201 , "Created");
        }
        // エラー　保存に失敗
        else {
          $this->response->setStatusCode(400 , "Bad Request");
        }
      } 
      // エラー　モデルが見つからない
      else {
        $this->response->setStatusCode(404, "Not Found");
      }
      // クロスドメイン
      $this->response->setHeader('Access-Control-Allow-Origin', '*');
      $this->response->setHeader('Access-Control-Expose-Headers', 'Location');
  }

  // PUT /api/models/1
  // 指定モデルの更新
  public function putEndpointAction(...$params)
  {
      // 通常のビューテンプレートを無効化
  	  $this->view->disable();
      // パラメータからモデルを取得する
      $model = $this->execute_by_params($params);
      // 更新するモデルのPOSTデータを取得
      $post_data = $this->request->getJsonRawBody(true);
      
      // 一意のモデルが取得出来ているか確認
      if($model instanceof \Phalcon\Mvc\Model) {
        // モデルをDBに反映
        if(is_array($post_data) && $model->assign($post_data) && $model->update() == true) {
          // 正常に終了した
          $this->response->setStatusCode(204, "No Content");
        }
        // エラー　保存に失敗
        else {
          $this->response->setStatusCode(400 , "Bad Request");
        }
      } 
      // エラー　モデルが見つからない
      else {
        $this->response->setStatusCode(404, "Not Found");
      }
      // クロスドメイン
      $this->response->setHeader('Access-Control-Allow-Origin', '*');
  }

  // DELETE /api/models/1
  // 指定モデルの削除
  public function deleteEndpointAction(...$params)
  {
    // 通常のビューテンプレートを無効化
    $this->view->disable();
    // パラメータからモデルを取得する
    $model = $this->execute_by_params($params);
    
    // 一意のモデルが取得出来ているか確認
    if($model instanceof \Phalcon\Mvc\Model) {
      // 指定モデルを削除
      if($model->delete() == true) {
        // 正常終了ステータスコード
        $this->response->setStatusCode(204, "No Content");
      }
      // エラー　削除できなかった場合
      else {
        $this->response->setStatusCode(409, "Conflict");
      }
    } 
    // エラー　削除するモデルが見つからない
    else {
      $this->response->setStatusCode(404, "Not Found");
    }
    // クロスドメイン
    $this->response->setHeader('Access-Control-Allow-Origin', '*');
  }
  
  // OPTIONS /*
  // 使用可能HTTPメソッドの送信
  public function optionsEndpointAction()
  {
    // 通常のビューテンプレートを無効化
    $this->view->disable();
    // HTTPメソッド
    $this->response->setHeader('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, OPTIONS');
    // クロスドメイン
    $this->response->setHeader('Access-Control-Allow-Origin', '*');
    // HTTPステータス
    $this->response->setStatusCode(200, "OK");
  }
  
  // "/hoge/1/hoge_children/2/" 等のパラメータを配列にしたものを指定すると、そのモデルを返す
  // "/hoge/1/hoge_children/2/start" だと、hoge_childrenのID2のstartメソッドが実行され、それの戻り値が返される
  // "/hoge/1/hoge_children/" だと、ID1のhogeのhoge_childrenの一覧が返される
  private function execute_by_params($params) 
  {
    $param = ucfirst(MyLib::camelize(array_shift($params)));
    $function_result = null;
    $model = null;
    $models = $param::find();
    while(count($params) > 0)
    {
      $param = array_shift($params);

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
            // modelsを更新
            $models = $property;
            $model = null;
          }
          // 一意の場合、modelを更新
          else
          {
            // modelを更新
            $model = $property;
            $models = null;
          }
        }
        // エラー 指定された名前のプロパティもメソッドも見つからない
        else {
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
              break;
            }
          }
          // エラー　指定されたIDのモデルが見つからない
          if(!$model) {
            // 今のところエラー処理なし
          }
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

    // 最後にモデル or モデル一覧 or メソッド実行結果を返す
    if($model) {
      return $model;
    }
    else if($models) {
      return $models;
    } else if($function_result) {
      return $function_result;
    }
    
    // 何も取得できなかった場合、nullを返す　（パラメータが不正）
    return null;
  }

  // jsonで出力する
  // GETのcallbackパラメータを取得し、json or jsonpを自動で判断する
  private function output_for_json($var)
  {
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
}
