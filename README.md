# Atte(勤怠管理アプリ)
勤怠管理アプリです。
![トップ画面](src/top.png)
## 作成した目的
クライアント企業からの、人事評価用の勤怠管理システム構築を想定し、
実践に近い形での開発過程をアウトプットとして記録するため作成しました。

## URL
- 開発環境：http://localhost/
- phpMyAdmin：http://localhost:8080/
- MailHog：http://localhost:8025/
- 本番環境：http://35.77.94.54/
- 本番環境 phpMyAdmin：http://35.77.94.54:8080/
- 本番環境 MailHog：http://35.77.94.54:8025/

## 使用技術(実行環境)
- PHP8.3.9
- Laravel8.83.27
- MYSQL8.0.26

## 機能一覧
会員登録、メール認証、ログイン、ログアウト、勤務の開始と終了、休憩の開始と終了、日付別勤怠情報取得、日付検索、ページネーション、ユーザー一覧情報取得、ユーザー情報検索、ユーザー別勤怠情報取得

## 環境構築
**Dockerビルド**
1. `git clone git@github.com:eto0831/attendance-2.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

## テーブル設計
![テーブル設計](src/table.png)

## ER図
![ER図](src/erd.png)

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または新しく「.env」ファイルを作成
4. .envに以下の環境変数を追加
``` text
APP_NAME=Atte

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

PMA_ARBITRARY=1
PMA_HOST=mysql
PMA_USER=laravel_user
PMA_PASSWORD=laravel_pass

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="${APP_NAME}"
```
5. アプリケーションキーの作成
``` bash
php artisan key:generate
```

6. マイグレーションの実行
``` bash
php artisan migrate
```

7. シーディングの実行
``` bash
php artisan db:seed
```
## テストアカウント
シーディングを実行すると

## 注意事項
.envファイルがスクールでの通常のプロジェクトの設定と少し異なっているため、
お手数ですが上記のLaravel環境構築に記載の環境変数をご入力ください。
