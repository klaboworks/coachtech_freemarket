# coachtech フリマ

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

## ER 図

# 環境構築

### git をクローン

-

### PHP コンテナを生成して起動/ログイン

- `docker-compose up -d --build`
- `docker-compose exec php bash`

### パッケージをインストール

- `composer install`

### .env ファイルを作成

- `cp .env.example .env`

### MAILER 送信設定

- .env ファイルの MAIL の項目を任意の設定に更新

### .env ファイのル DB 項目を下記に変更

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

### アップロード画像表示機能オン

- `php artisan storage:link`

## 備考
