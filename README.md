# README

RaspberryPi用のホームオートメーションサーバです。

リモコンの赤外線情報の記憶・送信、スケジューリング等をRESTfulAPIでやります。

## 環境
raspberry pi + nginx + php7 + php-phalcon + volt + bootstrap

## 環境構築

Raspberry Piへの環境構築手順

```
# ---nginxをインストール---
sudo apt-get install nginx

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

# ---iptables,firewalld---
# なんかやる

# ---nginxを起動---
# 接続の確認

```

## 環境簡単説明

### nginxってなに？
Webサーバー

受け取ったリクエストに対して処理を割り振り、結果のレスポンスを返すだけの物

### phpってなに？
Webサーバーから割り振られた処理を受け取り、最終的にはHTMLを返すのが役割

また、動作する環境が大きく2つある

1. Webサーバーのプロセス上（モジュール形式 Apache等）
2. または完全に独立した別プロセス（FastCGI形式 nginx等）

### nginxとphpのプロセス間通信について
だいたいUNIXドメインソケットを使っている

UNIXドメインソケットは以下の様なものです。
1. サーバー側が`listen hogehoge`とかをすると`/tmp/hogehoge.sock`みたいなファイルが出来る。
2. クライアント側はこのsockファイルを指定する事によりサーバー側とのコネクションが確立される。
3. listenを閉じるとsockファイルも消えて通信が閉じる
4. サーバー側は使用するポートを指定しなければならない

### phalconってなに？
phpのWebアプリケーションフレームワーク

生のPHPでHTMLを吐き出すのは凄く面倒くさいので、そこら辺をいい感じにサポートしてくれる。

### voltってなに？
テンプレートエンジンと言って、HTMLタグとPHPコードを織り交ぜて書くことが出来ます。
もっと簡単にいうとPHPが書けるHTMLです。

生でHTMLを書いているより格段に書きやすいです。

HTML内でfor文が使えるのは最初感動します。

### bootstrapってなに？
HTML用のデザイン詰め合わせパック  
css,javascriptで作られてます

通常、デザインする際は画像を用意したり、ボタンの角を丸くするためにCSSを書いたり、リッチなプルダウンメニューを実現する為に2時間も3時間も費やしたりします

Bootstrapはそれらの詰め合わせで、HTMLのclassタグに一言書き込むだけでとてもリッチにデザインしてくれます
