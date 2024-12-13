## ルーティング

| メソッド | URI              | アクション                 | 説明                       |
| -------- | ---------------- | -------------------------- | -------------------------- |
| GET      | /contents        | ContentController@index    | コンテンツ一覧表示         |
| GET      | /contents/{id}   | ContentController@show     | コンテンツ詳細表示         |
| POST     | /contents        | ContentController@store    | コンテンツ作成             |
| PUT      | /contents/{id}   | ContentController@update   | コンテンツ更新             |
| DELETE   | /contents/{id}   | ContentController@destroy  | コンテンツ削除             |
| POST     | /api/transcripts | TranscriptController@store | 文字起こしデータの AI 処理 |
| GET      | /search          | SearchController@index     | 検索フォーム表示           |
| GET      | /api/search      | SearchController@search    | 検索 API                   |
