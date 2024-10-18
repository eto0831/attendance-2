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

## テーブル設計
![テーブル設計](src/table.png)

## ER図
![ER図](src/erd.png)

## テストアカウントおよび確認ができるサンプルケース
シーディングを実行すると下記アカウントおよびデータの作成が行われます。

メールアドレス：popo1@example.com ～ popo35@example.com
各ユーザー名：@の前の部分(例：popo1@example.comの場合は popo1)
パスワード：popo1212 （共通）

【確認ができるサンプルケース】
popo1〜popo5: 7日前から前日まで、毎日9時から18時まで出勤、12時から1時間と15時から15分休憩、18時退勤  
popo6〜popo10: 7日前から前日まで、毎日9時から18時まで出勤、12時から1時間休憩、18時退勤  
popo11〜popo15: 前々日9時から出勤したままの状態  
popo16〜popo20: 前々日9時から出勤、15時から休憩入りのままの状態  
popo21〜popo25: 前日9時から出勤したままの状態  
popo26〜popo30: 前日9時から出勤、15時から休憩入りのままの状態  
popo31〜popo35: 前日9時から出勤、12時から1時間休憩と15時から15分休憩、18時退勤  

※勤務終了を押さない状態で24時を迎え、後日ログインすると下記の状態となります。  
・前々日以前（2日以上開けてしまった場合）：最終の打刻日の23時59分59秒での退勤となり、以降のデータは作成されません。  
・前日：前日の23時59分59秒で勤務終了となり、本日の0時0分0秒での出勤開始状態になります。  

※休憩終了を押さない状態で24時を迎え、後日ログインすると下記の状態となります。
・前々日以前（2日以上開けてしまった場合）：最終の打刻日の23：59：59休憩終了および退勤となり、以降のデータは作成されません。  
・前日：前日の23時59分59秒で勤務終了および休憩終了となり、本日の0時0分0秒での出勤開始、および休憩を開始している状態になります。  

## 注意事項
.envファイルがスクールでの通常のプロジェクトの設定と少し異なっているため、
お手数ですが上記のLaravel環境構築に記載の環境変数をご入力ください。
