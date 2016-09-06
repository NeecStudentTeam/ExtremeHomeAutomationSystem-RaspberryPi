# ExtremeHomeAutomationSystem-RaspberryPi

RaspberryPi用のホームオートメーションサーバです。

リモコンの赤外線情報の記憶・送信、スケジューリング等をRESTful APIでやります。

## 環境
raspberry pi + nginx + php7 + php-phalcon + volt + bootstrap

下の方で説明してます。

## 環境構築(xampp)

Windows XAMPP環境への構築

### XAMPPインストール
https://www.apachefriends.org/download.html  
PHP7 32Bit をインストール

### Phalconモジュールをインクルード
https://phalconphp.com/ja/download/windows  
Phalcon 3.0.0 - Windows x86 for PHP 7.0.0 (vc14) をダウンロードし、解凍

`C:\xampp\php\ext`に`php_phalcon.dll`を入れる

`C:\xampp\php\php.ini`に以下を追記
```
extension=php_phalcon.dll
```

### Gitからプロジェクトをデプロイ

以下のフォルダを空にし、以下のフォルダにgit pull
`C:\xampp\htdocs`

### 確認

XAMPPでApacheを起動

以下にアクセス
http://localhost/

エラーが発生しなかったら完了

## 環境構築(pi)

Raspberry Piへの環境構築手順

未完成

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

### nginx
Webサーバー

受け取ったリクエストに対して処理を割り振り、結果のレスポンスを返すだけの物

### php
Webサーバーから割り振られた処理を受け取り、最終的にはHTMLを返すのが役割

また、動作する環境が大きく2つある

1. Webサーバーのプロセス上（モジュール形式 Apache等）
2. または完全に独立した別プロセス（FastCGI形式 nginx等）

### nginxとphpのプロセス間通信
だいたいUNIXドメインソケットを使っている

UNIXドメインソケットは以下の様なもの。

1. サーバー側が`listen hogehoge`とかをすると`/tmp/hogehoge.sock`みたいなファイルが出来る。
2. クライアント側はこのsockファイルを指定する事によりサーバー側とのコネクションが確立される。
3. listenを閉じるとsockファイルも消えて通信が閉じる
4. サーバー側は使用するポートを指定しなければならない

### phalcon
phpのWebアプリケーションフレームワーク

生のPHPでHTMLを吐き出すのは凄く面倒くさいので、そこら辺をいい感じにサポートしてくれる。

### volt
テンプレートエンジン。HTMLタグとPHPコードを織り交ぜて書くことが出来る。
HTML内でモデルにアクセスできる。for文が使える。等。

### bootstrap
HTML用のデザイン詰め合わせパック  
css,javascriptで作られている

アイコン画像を用意したり、ボタンの角を丸くするためにCSSを書いたり、リッチなプルダウンメニューを実現する為に2時間も3時間も費やしたりしなくて良い

Bootstrapはそれらの詰め合わせで、HTMLのclassタグに一言書き込むだけでリッチにデザインししてくれる
