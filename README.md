# Chodoii Task
### ロゴ
![dev2logo](https://github.com/shtk0119/Apprentice_Dev1/assets/119676984/30ab5b10-e50c-438d-838a-492055120c56)

### サイト内画像
<img width="1469" alt="スクリーンショット 2024-01-27 13 10 40" src="https://github.com/shtk0119/Apprentice_Dev1/assets/119676984/e6132c60-d386-41d8-aeb2-c7637c258d8b">

## テーマ
**タスクに対して実績を踏まえた定量情報でタスク管理**  
実績がともなったタスク管理をしていければ、より効率的にタスクを積み上げてイレギュラータスクが発生しても柔軟に対応できる

## テーマを選んだ理由
**なぜ自分で作ったタスクをこなせないのか？**  
それは、タスクに対して見積もりが甘くなるから。  
「納期が遅れて、後これくらいでできます。」と言ってだいたいギリギリもしくは終わらない。  
人は見積もりにバイアスがかかってしまう。経験していることでも時間の見積もりを正確にできない。未経験の挑戦をしていればなおさら。エビデンスは何もないのに、経験したことあるからという定性情報だけで定量情報が皆無。  
そう言った見積もりに対しての時間の誤差をなるべく無くしたと考えこのアプリケーションを作りに至りました。

## 機能一覧
各機能の説明

## アーキテクチャ
![dev1_architecture drawio](https://github.com/shtk0119/Apprentice_Dev1/assets/119676984/42d5b52c-cc02-4c03-9f72-fef201268acb)

## ER図
![dev1 drawio](https://github.com/shtk0119/Apprentice_Dev1/assets/119676984/b890d81b-0306-4ad4-b8ad-76537e7b7cde)

## 使用技術
- HTML
- CSS
- SASS
- JavaScript
- PHP 8.3.1
- MySQL 8.2.0
- Apache
- Docker
- GitHub

## 起動
**イメージ構築&コンテナ作成&コンテナ起動**
```
docker compose up -d --build
```
|オプション|意味|
| ----- | ----- |
|-d     |バックグラウンドでコンテナを実行|
|--build|コンテナを開始前にイメージを構築する(変更があった場合のみ)|

**起動確認**
```
docker compose ps

docker ps
```

**コンテナ内へ入る**
```
docker compose exec <サービス名> bash

docker container exec -it <コンテナ名 or コンテナID> bash

docker exec -it <コンテナ名 or コンテナID> bash
```
|オプション|意味|
| ----- | ----- |
|-i     |標準入力を開き続ける。|
|-t     |疑似ttyを割りあてる。|
|-it    |手元の環境で、docker内入力ができるようにする。|

**コンテナ内から出る**
```
exit
```

## 停止
**コンテナ停止**
```
docker compose stop
```

## 削除
**コンテナ削除**
```
docker compose down
```

**コンテナ&ボリューム&イメージ削除**
```
docker comopse down --rmi all --volumes
```
|オプション|意味|
| ----- | ----- |
|--rmi  |削除するイメージの種類を指定する。（allはすべてのイメージ）|
|--volumes|名前付きボリュームが削除される。|
