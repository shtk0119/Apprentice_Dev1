## UP
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