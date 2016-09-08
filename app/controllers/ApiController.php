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
          $this->view->disable();

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
              echo json_encode($models[$last_param]);
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
              echo json_encode($error);
            }
          }
          // 数値じゃなかった場合、全てのモデル
          else {
            echo json_encode($models);
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

          echo json_encode($model);
    }

    // DELETE /api/models/1
    // 指定モデルの削除
    public function deleteEndpointAction(...$params)
    {
					$this->view->disable();
          $this->response->setStatusCode(204, "No Content");
    }
}
