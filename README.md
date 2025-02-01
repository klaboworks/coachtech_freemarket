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

### キーを作成

- `php artisan key:generate`

### マイグレーション+データシーディング

- `php artisan migrate --seed`

### アップロード画像表示機能オン

- `php artisan storage:link`

# 環境変数設定

### .env ファイルを作成

- `cp .env.example .env`

### MAILER 送信設定

- .env ファイルの MAIL の項目を任意の設定に更新

### .env ファイのル LOCAL 項目を下記に変更

    APP_LOCALE=ja
    APP_FALLBACK_LOCALE=ja
    APP_FAKER_LOCALE=ja_JP

### .env ファイのル DB 項目を下記に変更

    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=laravel_db
    DB_USERNAME=laravel_user
    DB_PASSWORD=laravel_pass

### .env ファイルに下記の項目を追加

    STRIPE_KEY= ここにストライプの公開鍵を入力してください
    STRIPE_SECRET= ここにストライプの秘密鍵を入力してください

# テスト環境整備

### テスト用データベース作成

- Mysql コンテナにログイン
- 'test_db'という名前のデータベースを作る
- 下記のコードで権限付与と権限の変更を MySQL サーバーに反映
- `GRANT ALL PRIVILEGES ON test_db.* TO 'laravel_user'@'%';`
- `FLUSH PRIVILEGES;`

### phpunit.xml 設定

- phpunit.xml を開き、env name="DB_DATABASE"の項目を下記に変更、コメントアウトを外す
  <env name="DB_DATABASE" value="test_db"/>

## 備考
