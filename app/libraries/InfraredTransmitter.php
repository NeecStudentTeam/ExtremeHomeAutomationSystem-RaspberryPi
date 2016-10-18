<?php 

class InfraredTransmitter {
  public static function send($value) {
    // ---排他処理開始---
    // $sem_id = sem_get(ftok(__FILE__, 'g'), 1);
    // if (!sem_acquire($sem_id)) {
    //     throw new Exception('sem_acquire failed');
    // }

    // ---赤外線送信処理---
    $is_test_mode = (ENVIRONMENT == 'development' ? 1 : 0);
    $exe_command = 'C:\bin\sendir ' . $value . ' ' . $is_test_mode;
    $output = array();
    exec($exe_command, $output);

    // ---排他処理終了---
    // if (!sem_release($res)) {
    //     throw new Exception('sem_release failed');
    // }
    
    return $output;
  }
  
}
