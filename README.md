## 備忘

- Nuxt3 プロジェクト作成

```bash
npx nuxi@latest init . --overwrite-dir
```

- Laravel プロジェクト作成

```bash
composer create-project --prefer-dist laravel/laravel . "9.*"
```

- Laravel storage

```bash
chown www-data:www-data ./storage/ -R
```

- api 確認

  - api.php
    ```php
    Route::get('/sample', function () {
        return response()->json(['msg' => '成功']);
    });
    ```
  - `http://localhost/api/sample`

- vuetify

```bash
npm install --save vuetify@next
npm install --save sass
npm i vue-tsc -D
```

- nginx にデプロイする方法はまだ未対応
