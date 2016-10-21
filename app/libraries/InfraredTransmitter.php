<?php

class InfraredTransmitter {
  public static function send($value) {
    // ---排他処理開始---
    if (!MyLib::isWindowsServer()) {
      $sem_id = sem_get(ftok(__FILE__, 'g'), 1);
      if (!sem_acquire($sem_id)) {
          throw new Exception('sem_acquire failed');
      }
    }

    // ---赤外線送信処理---
    $is_test_mode = (ENVIRONMENT == 'development' ? 1 : 0);
    $exe_command = 'sendir ' . $value . ' ' . $is_test_mode;
    exec($exe_command, $output, $result);

    // コマンドが実行できない・もしくは存在しなかった場合
    if (!$result) {
      $output["error"] = "コマンド実行時にエラーが発生しました。";
    }

    // ---排他処理終了---
    if (!MyLib::isWindowsServer()) {
      if (!sem_release($sem_id)) {
          throw new Exception('sem_release failed');
      }
    }

    return $output;
  }

}
