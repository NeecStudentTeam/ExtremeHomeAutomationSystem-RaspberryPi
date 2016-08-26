# README

RaspberryPi用のホームオートメーションサーバです。
リモコンの赤外線情報の記憶・送信、スケジューリング等をRESTfulAPIでやります。

## 環境
raspberry pi + nginx + php-phalcon

## 環境構築
```
# ---nginxをインストール---

# ---phpをインストール---
# php7がいいなあ

# ---php-extensionのphalconをインストール---
# php_phalcon.dllをダウンロードし、php.iniに以下を記述する
# extension=php_phalcon.dll
# php_phalcon.dllの種類には気をつける事
# http://dim5.net/phalcon/php-install.html

# ---gitよりプロジェクト配置---

# ---vertual host設定---
# apacheの場合
# httpd-vhosts.confに記載
# http://dim5.net/phalcon/php-install.html

# nginxの場合

# ---nginxを起動---
# 接続の確認

```
