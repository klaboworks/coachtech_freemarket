# coachtech フリマ

フリーマーケットアプリ

## 環境構築

### git をクローン
`git clone git@github.com:klaboworks/coachtech_freemarket.git`

### Dockerビルド/PHPコンテナログイン
`docker-compose up -d --build`
`docker-compose exec php bash`

### パッケージをインストール
`composer install`

### キーを作成
`php artisan key:generate`

## 環境変数設定

### .env ファイルを作成
`cp .env.example .env`

### MAILER 送信設定
.env ファイルの MAIL の項目を任意の設定に更新

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

### マイグレーション+データシーディング
`php artisan migrate --seed`

### アップロード画像表示機能オン
`php artisan storage:link`

## 実行環境
言語：PHP 8.3.12</br>
フレームワーク：Laravel 11.40.0</br>
データベース：MySQL

## ER 図
![ER図](ER.png)

## URL
開発環境：http://localhost/

# テスト環境整備

### テスト用データベース作成

- Mysql コンテナにログイン
- 'test_db'という名前のデータベースを作る
- 下記のコードで権限付与と権限の変更を MySQL サーバーに反映
- `GRANT ALL PRIVILEGES ON test_db.* TO 'laravel_user'@'%';`
- `FLUSH PRIVILEGES;`

### phpunit.xml 設定
phpunit.xml を開き、env name="DB_DATABASE"の項目を下記に変更、コメントアウトを外す
  <env name="DB_DATABASE" value="test_db"/>

## 備考

- Laravel11使用のため認証系のバリデーションはFormRequest不使用