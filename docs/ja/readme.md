# Xampp vHosts Manager

Windows 上の Xampp 向け仮想ホストおよび自己署名 SSL 証明書管理システム。

**作者:** Jose Alexis Correa Valencia — [jalexiscv@gmail.com](mailto:jalexiscv@gmail.com)
**ライセンス:** [MIT](LICENSE)
**チェンジログ:** [changelog/changelog.md](changelog/changelog.md)
**ドキュメント:** [docs/es/](docs/es/readme.md) • [docs/en/](docs/en/readme.md)

![Xampp vHosts Manager](https://user-images.githubusercontent.com/9862115/70820328-f78de800-1e0a-11ea-894a-b7021942c158.jpg)

---

## 目次

- [説明](#説明)
- [特徴](#特徴)
- [互換性](#互換性)
- [要件](#要件)
- [インストール](#インストール)
  - [手動ダウンロード](#手動ダウンロード)
  - [マネージャーのインストール](#マネージャーのインストール)
- [アップデート](#アップデート)
- [使用方法 — コンソール (xvhost)](#使用方法--コンソール-xvhost)
  - [ヘルプ](#ヘルプ)
  - [仮想ホストの作成](#仮想ホストの作成)
  - [ホスト情報の表示](#ホスト情報の表示)
  - [全ホストの一覧表示](#全ホストの一覧表示)
  - [ホストの削除](#ホストの削除)
  - [SSL 証明書の追加](#ssl-証明書の追加)
  - [SSL 証明書の削除](#ssl-証明書の削除)
  - [Document Root の変更](#document-root-の変更)
  - [Apache の停止/起動/再起動](#apache-の停止起動再起動)
  - [アプリケーションパスの登録](#アプリケーションパスの登録)
  - [Windows hosts ファイルの権限設定](#windows-hosts-ファイルの権限設定)
- [Web パネル (グラフィカルインターフェース)](#web-パネル-グラフィカルインターフェース)
  - [Web パネルの要件](#web-パネルの要件)
  - [アクセス方法](#アクセス方法)
  - [パネルの機能](#パネルの機能)
- [SSL 証明書](#ssl-証明書)
  - [仕組み](#仕組み)
  - [Windows で CA 証明書を信頼する](#windows-で-ca-証明書を信頼する)
  - [Firefox で CA 証明書を信頼する](#firefox-で-ca-証明書を信頼する)
- [設定](#設定)
- [トラブルシューティング](#トラブルシューティング)
  - [SSL が生成されない](#ssl-が生成されない)
  - [ブラウザにセキュリティ警告が表示される](#ブラウザにセキュリティ警告が表示される)
  - [ホスト名が解決できない](#ホスト名が解決できない)
  - [Apache が起動しない](#apache-が起動しない)
  - [ホスト作成時の権限エラー](#ホスト作成時の権限エラー)
- [ライセンス](#ライセンス)

---

## 説明

Xampp vHosts Manager は、Windows 上の Xampp で仮想ホストの作成と管理を容易にするツールです。可能なこと:

- 数秒で仮想ホストを作成
- 複雑な OpenSSL コマンドを使わずに自己署名 SSL 証明書を生成
- コンソール (`xvhost`) またはインタラクティブな Web パネルから全てを管理

Xampp を使用し、複数のローカルドメインを SSL 付きで迅速かつ簡単に必要とする開発者向けに設計されています。

---

## 特徴

- カスタム名の仮想ホストを作成
- 既存の仮想ホストを削除
- ホストの詳細情報を表示
- 全ての仮想ホストを一覧表示
- 任意のホストに自己署名 SSL 証明書を追加
- ホストから SSL 証明書を削除
- 既存ホストの Document Root を変更
- Apache の起動、停止、再起動
- ダークモードのモダンな **Web パネル**
- Windows で信頼できるエンティティとしてインストール可能な独自 CA 証明書

---

## 互換性

- PHP 5.4 以降を使用する全ての Xampp バージョンと互換性あり
- Xampp ポータブル版は **非対応**
- 対応 OS: Windows のみ

---

## 要件

1. **Xampp がインストールされていること**（当然）
2. **PHP にアクセス可能** — インストーラーが Xampp の PHP パスを Windows の PATH に自動追加
3. **任意:** Composer がインストールされていること（Composer からインストールする場合のみ）

---

## インストール

### 手動ダウンロード（推奨）

1. [最新バージョン](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest) をダウンロード
2. 内容を共有可能な場所に展開（例: `C:\xampp\hosts` または `D:\xvhm`）
   > **重要:** `C:\Program Files` やファイル書き込みに管理者権限が必要な場所には配置しないでください
3. **管理者として** ターミナルを開く
4. マネージャーを展開したディレクトリに移動:
   ```cmd
   cd /D C:\xampp\hosts
   ```
5. インストーラーを実行:
   ```cmd
   xvhost install
   ```
6. 画面の指示に従う（Xampp のパス、推奨 DocumentRoot パスなど）
7. ターミナルを閉じる（一時的な環境変数をクリアするため）
8. 新しいターミナルを開く — これで任意の場所から `xvhost` を使用可能

### マネージャーのインストール

`xvhost install` コマンドは自動的に以下を実行:

- Windows の PATH 環境変数にマネージャーのパスを登録
- Xampp のパスで `settings.ini` ファイルを設定
- `cacert/` に認証局 (CA) 証明書を生成
- Windows の `hosts` ファイルに必要な権限を付与

---

## アップデート

1. `settings.ini` ファイルと `cacert/` フォルダをバックアップ
2. マネージャーディレクトリの全内容を削除
3. [最新バージョン](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest) をダウンロードし、同じディレクトリに展開
4. `settings.ini` ファイルと `cacert/` フォルダを復元

---

## 使用方法 — コンソール (xvhost)

インストール後、**管理者である必要なく** 任意のターミナルから `xvhost` を実行できます（システム設定を変更するコマンドを除く）。

### ヘルプ

```
xvhost help
```

### 仮想ホストの作成

```
xvhost new [ホスト名]
```

例:
```
xvhost new mistio.local
```

> `ホスト名` パラメータは省略可能です。指定しない場合は、処理中に入力を求められます。

作成中に以下を尋ねられます:
- **Document Root** — サイトファイルが置かれるパス
- **管理者メールアドレス**
- **SSL を追加しますか？** — 「はい」の場合、自己署名 SSL 証明書が自動生成されます

### ホスト情報の表示

```
xvhost show [ホスト名]
```

例:
```
xvhost show mistio.local
```

### 全ホストの一覧表示

```
xvhost list
```

### ホストの削除

```
xvhost remove [ホスト名]
```

例:
```
xvhost remove mistio.local
```

Apache の設定、SSL（存在する場合）、Windows の `hosts` ファイルのエントリが削除されます。

### SSL 証明書の追加

```
xvhost add_ssl [ホスト名]
```

例:
```
xvhost add_ssl mistio.local
```

### SSL 証明書の削除

```
xvhost remove_ssl [ホスト名]
```

### Document Root の変更

```
xvhost change_docroot [ホスト名]
```

### Apache の停止/起動/再起動

```
xvhost stop_apache
xvhost start_apache
xvhost restart_apache
```

### アプリケーションパスの登録

マネージャーを別のフォルダに移動した場合、新しいパスを登録できます:

```
xvhost register_path
```

> 管理者権限が必要です。

### Windows hosts ファイルの権限設定

マネージャーが Windows の `hosts` ファイルに自動的にエントリを追加できるようにするには:

```
xvhost grantperms_winhosts
```

> 管理者権限が必要です。一度だけ実行すれば十分です。

---

## Web パネル (グラフィカルインターフェース)

コンソールに加えて、プロジェクトにはブラウザからアクセス可能な **モダンな Web パネル** が含まれています。

### Web パネルの要件

- Apache と PHP が動作していること（当然）
- マネージャーのディレクトリが Apache のドキュメントツリー内にあるか、それを指す仮想ホストが設定されていること

### アクセス方法

マネージャーを `C:\xampp\hosts` にインストールした場合:

**オプション A — 仮想ホスト:** ディレクトリを指す仮想ホストを作成:
```
xvhost new xvhm.local
```
Document Root を尋ねられたら `C:\xampp\hosts` と入力し、`http://xvhm.local` にアクセス

**オプション B — PHP で直接起動:** ターミナルを開いて以下を実行:
```
C:\xampp\php\php.exe -S localhost:8080 -t C:\xampp\hosts
```
その後 `http://localhost:8080` にアクセス

### パネルの機能

Web パネルでは以下が可能:

- **全仮想ホストを SSL 状態付きで表示**
- **フォームを使って新しいホストを作成**（名前、Document Root、メール、SSL）
- **ワンクリックでブラウザでホストを開く**
- **ホストを直接削除**
- **Apache の制御**（起動、停止、再起動）
- **Apache の状態をリアルタイムで表示**
- ダークモードデザインのインターフェース

---

## SSL 証明書

### 仕組み

マネージャーは2種類の証明書を扱います:

1. **ルート CA 証明書** (`cacert/cacert.crt`) — インストール時に一度だけ生成されます。全ての仮想ホスト証明書に署名する認証局です。

2. **ホスト証明書** — SSL を有効にした各ホストは、ルート CA によって署名された独自の証明書を受け取ります。証明書にはホスト名および `www.*` の Subject Alternative Names (SAN) が含まれます。

**格納場所:**
- CA 証明書: `C:\xampp\hosts\cacert\`
- ホスト証明書: `C:\xampp\apache\conf\extra\certs\`
- 秘密鍵: `C:\xampp\apache\conf\extra\keys\`
- Apache SSL 設定: `C:\xampp\apache\conf\extra\vhosts_ssl\`

### Windows で CA 証明書を信頼する

`https://tusitio.local` にアクセスした時にブラウザが **セキュリティ警告を表示しない** ようにするには:

1. **管理者として** ターミナルを開く
2. 以下を実行:
   ```cmd
   certutil -addstore -f Root C:\xampp\hosts\cacert\cacert.crt
   ```
   （マネージャーを別のディレクトリにインストールした場合はパスを調整してください）
3. ブラウザを再起動

**Chrome または Edge** を使用している場合:
- `chrome://settings/security` → 証明書の管理 → インポート に移動
- `C:\xampp\hosts\cacert\cacert.crt` を選択
- 「信頼されたルート証明機関」を選択
- 完了

### Firefox で CA 証明書を信頼する

Firefox は Windows とは独立した独自の証明書ストアを使用します:

1. Firefox を開く
2. **設定** → **プライバシーとセキュリティ** → **証明書** に移動
3. **証明書を表示** をクリック → **認証局** タブ
4. **インポート** をクリック
5. `C:\xampp\hosts\cacert\cacert.crt` を選択
6. **「この認証局によるウェブサイトの識別を信頼する」** にチェック
7. 同意する

---

## 設定

全ての設定はマネージャーディレクトリ内の `settings.ini` ファイルにあります:

```ini
[DirectoryPaths]
; Xampp インストールパス
Xampp = "C:\xampp"

[Suggestions]
; 新しいホスト作成時に推奨される DocumentRoot パス
; {{host_name}} はホスト名に置き換えられます
DocumentRoot = "C:\xampp\hosts\{{host_name}}"

; 推奨される ServerAdmin メールアドレス
AdminEmail = "admin@localhost"

[ListViewMode]
; ホスト一覧表示時の1ページあたりの表示件数
RecordPerPage = "5"
```

---

## トラブルシューティング

### SSL が生成されない

**症状:** `xvhost add_ssl mistio.local` を実行しても、証明書が作成されずに処理が失敗する。

**原因:** 以前のバージョンでは、証明書のシリアル番号を `php -r "echo md5(...)"` で生成していましたが、システム PATH に `php` が含まれていませんでした。現在のバージョンでは `openssl rand -hex 16` を使用して修正されています。

**解決策:** 最新バージョンのマネージャーを使用していることを確認してください。問題が続く場合は、`C:\xampp\apache\bin\openssl.exe` が存在するか確認してください。

### ブラウザにセキュリティ警告が表示される

**症状:** `https://mistio.local` を開くと「この接続はプライベートではありません」(NET::ERR_CERT_AUTHORITY_INVALID) と表示される。

**原因:** SSL 証明書はローカル CA によって署名されていますが、Windows/Firefox がその CA を信頼していません。

**解決策:** CA 証明書を信頼できるエンティティとしてインストールしてください（[Windows で CA 証明書を信頼する](#windows-で-ca-証明書を信頼する) のセクションを参照）。

### ホスト名が解決できない

**症状:** `http://mistio.local` が読み込めず、「サーバーが見つかりません」と表示される。

**原因:** ホストが Windows の `hosts` ファイルに登録されていません。

**解決策:** 管理者として `xvhost grantperms_winhosts` を実行したことを確認してください（一度だけ必要）。その後、`xvhost new mistio.local` でホストを作成するか、手動で以下を `C:\Windows\System32\drivers\etc\hosts` に追加:
```
127.0.0.1   mistio.local
127.0.0.1   www.mistio.local
```

### Apache が起動しない

**症状:** ホストのインストールまたは変更後、Apache が起動しない。

**考えられる原因と解決策:**
- **ポートが使用中:** 別のプログラム（Skype、IIS、Docker など）がポート 80 または 443 を使用しています。そのプログラムを停止するか、`C:\xampp\apache\conf\httpd.conf` でポートを変更してください
- **構文エラー:** 以下で確認:
  ```cmd
  C:\xampp\apache\bin\httpd.exe -t
  ```
- **OpenSSL が見つからない:** `C:\xampp\apache\bin\openssl.exe` が存在することを確認
- **SSL の競合:** 壊れた SSL 設定がある場合、`C:\xampp\apache\conf\extra\vhosts_ssl\` のファイルを確認

### ホスト作成時の権限エラー

**症状:** ホスト作成時または `hosts` ファイルへの書き込み時に「Permission denied」エラーが発生する。

**解決策:** 以下を一度実行:
```
xvhost grantperms_winhosts
```
管理者として実行してください。以降は管理者権限なしでホストを作成できます。

---

## ライセンス

[MIT](LICENSE) © Jose Alexis Correa Valencia
