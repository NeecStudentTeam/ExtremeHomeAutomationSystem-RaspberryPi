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
  // GET /api/models
  // GET /api/models/1
  // モデルの表示
  public function getEndpointAction(...$params)
  {
  $callback = $this->request->getQuery('callback');

    // テスト用のモデルっぽいものを作成しておく
    $models = array();
    for($i = 0; $i < 20; $i++) {
      $models[] = array(
        'id' => $i,
        'name' => 'TestModel' + $i,
        'created_at' => '2011/01/01 20:00:00'
      );
    }

    $last_param = array_pop($params);
    // 数値だった場合、一意のモデル
    if(is_numeric($last_param)){
      // 指定IDのモデルが存在するかどうか
      if(array_key_exists($last_param,$models)){
        $this->output_for_json($models[$last_param]);
      }
      // 見つからなかったらエラー
      else {
        $this->response->setStatusCode(404, "Not Found");
        // エラーメッセージを出力
        $error = array(
          'error' => array(
            'code'    => 404,
            'message' => '指定IDのモデルが存在しません。'
          )
        );
        $this->output_for_json($error);
      }
    }
    // 数値じゃなかった場合、全てのモデル
    else {
      $this->output_for_json($models);
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
  // callbackを指定するとjsonpで出力する
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
}
