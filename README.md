# ExtremeHomeAutomationSystem-RaspberryPi

RaspberryPi用のホームオートメーションサーバです。

リモコンの赤外線情報の記憶・送信、スケジューリング等をRESTful APIでやります。

## 環境
raspberry pi + nginx + php7 + php-phalcon + volt + bootstrap

下の方で説明してます。

## Composer
composer使用してます。
プロジェクトディレクトリで以下コマンドを実行し、ライブラリをインストール・アップデートしてください。

`php composer.phar install`

## DBマイグレーション
Phalcon Dev Toolsでマイグレーションしてます。

DB名は`home_automation`なので、作成してから実行してください。  
プロジェクトディレクトリで以下を実行すると、DBが更新されます。

`.\vendor\phalcon\devtools\phalcon migration run`

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

### composerとか
composerとかDBマイグレーションとかする。  

### 確認

XAMPPでApacheを起動

以下にアクセス
http://localhost/

エラーが発生しなかったら完了


## 環境構築(pi)

Raspberry Piへの環境構築手順

```

# ---Webアプリケーション用のユーザーを作成する---
# ユーザーが所属するグループを作成
sudo groupadd app
# グループを指定してユーザー追加
sudo useradd -g app -m app
# 以下コマンド入力後、パスワードを入力
sudo passwd app
# ログ閲覧用グループを追加
usermod -aG adm app
# sudo用グループを追加
usermod -aG sudo app

# ---SU権限付与---
sudo visudo
# 以下を追記
# app ALL = (ALL)NOPASSWD: ALL

# ---gitよりプロジェクト配置---
# インストール
sudo apt-get install git
# フォルダ作成
su app
mkdir ~/projects
# gitよりclone
git clone https://github.com/NeecStudentTeam/ExtremeHomeAutomationSystem-RaspberryPi.git ~/projects/ehas-server

# ---nginxをインストール---
sudo apt-get install nginx

# ---php7fpmインストール---
# http://qiita.com/tieste/items/3c18749ec0218ffddf96
# ファイルに追記しリポジトリを追加
sudo echo 'deb http://repozytorium.mati75.eu/raspbian jessie-backports main contrib non-free' >> /etc/apt/sources.list
sudo echo '#deb-src http://repozytorium.mati75.eu/raspbian jessie-backports main contrib non-free' >> /etc/apt/sources.list
# リポジトリの公開鍵を登録
gpg --keyserver pgpkeys.mit.edu --recv-key CCD91D6111A06851
gpg --armor --export CCD91D6111A06851 | apt-key add -
# APTをアプデート
sudo apt-get update
# リポジトリからインストール
sudo apt-get install php7.0 php7.0-dev php7.0-fpm php7.0-mysql

# 以下ファイルを変更
# http://qiita.com/tieste/items/3c18749ec0218ffddf96
sudo vi /etc/php/7.0/fpm/php-fpm.conf
# daemonizeをyesに

# 以下ファイルを変更
# http://qiita.com/tieste/items/3c18749ec0218ffddf96
sudo vi /etc/php/7.0/fpm/pool.d/www.conf
# userとgroupの箇所を編集

# ---nginx設定---
# ドキュメントルートをプロジェクトの./publicに指定
# 必要な場合はバーチャルホストの設定をする
sudo vi /etc/nginx/sites-available/default
sudo ln -s /etc/nginx/sites-enabled/default

# nginx起動ユーザ変更
sudo vi /etc/nginx/nginx.conf
# userをappに

# ---pahlconモジュールのコンパイルと読み込み---
# https://phalconphp.com/ja/download
# pahlconモジュールのコンパイルに必要なパッケージをインストールする
sudo apt-get install gcc libpcre3-dev

# コンパイルとインストール
cd ~/
git clone --depth=1 git://github.com/phalcon/cphalcon.git
cd cphalcon/build
sudo ./install
# 必要に応じて作業フォルダを削除
rm -rf ~/cphalcon

# PHPにphalcon読みこませる
# 読み込ませるiniファイルを作成
sudo echo "extension=phalcon.so" >> /etc/php/7.0/mods-available/phalcon.ini
# シンボリックリンクでcond.dに放り込む
sudo ln -s /etc/php/7.0/mods-available/phalcon.ini /etc/php/7.0/fpm/conf.d/20-phalcon.ini
sudo ln -s /etc/php/7.0/mods-available/phalcon.ini /etc/php/7.0/cli/conf.d/20-phalcon.ini
# phalconモジュールが読み込まれている確認
php -m | grep phalcon

# ---iptables,firewalld---
# なんかやる

# ---nginxを起動---
# 確認

# ---MySQL---
# インストール
sudo apt-get install mysql-server
# インストール後、"home-automation"DBを作成

# ---composerとかマイグレーションとかする---

# ---WiringPIのインストール---
sudo apt-get install libi2c-dev
cd ~
git clone git://git.drogon.net/wiringPi
cd wiringPi
./build
# 確認
gpio

```

## ファイルパスメモ(pi)

```
sudo tail -f /var/log/php7.0-fpm.log
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
2. クライアント側がこのsockファイルを指定する事によりサーバー側とのコネクションが確立される。
3. listenを閉じるとsockファイルも消えて通信が閉じる
4. TCPにて通信を行うので、サーバー側は使用するポートを指定しなければならない。このポートはコンピュータ内で被ってはならない。

### phalcon
phpのWebアプリケーションフレームワーク

生のPHPでHTMLを吐き出すのは凄く面倒くさいので、そこら辺をいい感じにサポートしてくれる。

### volt
テンプレートエンジン。HTMLとPHPコードを織り交ぜて書くことが出来る。
HTML内でモデルにアクセスできる。for文が使える。等。

### bootstrap
HTML用のデザイン詰め合わせパック  
css,javascriptで作られている

アイコン画像を用意したり、ボタンの角を丸くするためにCSSを書いたり、リッチなプルダウンメニューを実現する為に2時間も3時間も費やしたりしなくて良い

Bootstrapはそれらの詰め合わせで、HTMLのclassタグに一言書き込むだけでリッチにデザインししてくれる
