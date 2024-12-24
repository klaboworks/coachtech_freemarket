# coachtechフリマ
フリーマーケットアプリ

## 機能一覧
### ユーザー側
 - 会員登録
 - ログイン
 - ログアウト
 - 商品の出品
 - 商品の購入
 - 商品の検索
 - 商品のお気に入り登録
 - 商品のお気に入り削除


## 実行環境
言語：PHP 8.3.12  
フレームワーク：Laravel 11.36.1 
データベース：MySQL

## テーブル設計


## ER図


# 環境構築
### gitをクローン
 - 
### PHPコンテナを生成して起動/ログイン
 - `docker-compose up -d --build`
 - `docker-compose exec php bash`
### パッケージをインストール
 - `composer install`
### .envファイルを作成
 - `cp .env.example .env`
### MAILER送信設定
 - .envファイルのMAILの項目を任意の設定に更新
### .envファイのルDB項目を下記に変更
    DB_CONNECTION=mysql  
    DB_HOST=mysql  
    DB_PORT=3306  
    DB_DATABASE=laravel_db  
    DB_USERNAME=laravel_user  
    DB_PASSWORD=laravel_pass  
### キーを作成
 - `php artisan key:generate`
### マイグレーション+データシーディング
 - `php artisan migrate --seed`

## 備考