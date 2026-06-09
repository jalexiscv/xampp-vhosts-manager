# Xampp vHosts 管理器

适用于 Windows 上 Xampp 的虚拟主机和自签名 SSL 证书管理系统。

**作者:** Jose Alexis Correa Valencia — [jalexiscv@gmail.com](mailto:jalexiscv@gmail.com)
**许可证:** [MIT](LICENSE)
**更新日志:** [changelog/changelog.md](changelog/changelog.md)
**文档:** [docs/es/](docs/es/readme.md) • [docs/en/](docs/en/readme.md)

![Xampp vHosts Manager](https://user-images.githubusercontent.com/9862115/70820328-f78de800-1e0a-11ea-894a-b7021942c158.jpg)

---

## 目录

- [描述](#描述)
- [功能特性](#功能特性)
- [兼容性](#兼容性)
- [系统要求](#系统要求)
- [安装](#安装)
  - [手动下载](#手动下载推荐)
  - [管理器安装流程](#管理器安装流程)
- [更新升级](#更新升级)
- [控制台命令使用 (xvhost)](#控制台命令使用-xvhost)
  - [帮助](#帮助)
  - [创建虚拟主机](#创建虚拟主机)
  - [查看主机信息](#查看主机信息)
  - [列出所有主机](#列出所有主机)
  - [删除主机](#删除主机)
  - [添加 SSL 证书](#添加-ssl-证书)
  - [删除 SSL 证书](#删除-ssl-证书)
  - [更改 Document Root](#更改-document-root)
  - [停止/启动/重启 Apache](#停止启动重启-apache)
  - [注册应用路径](#注册应用路径)
  - [Windows hosts 文件权限](#windows-hosts-文件权限)
- [Web 面板（图形界面）](#web-面板图形界面)
  - [Web 面板要求](#web-面板要求)
  - [如何访问](#如何访问)
  - [面板功能](#面板功能)
- [SSL 证书](#ssl-证书)
  - [工作原理](#工作原理)
  - [在 Windows 中信任 CA 证书](#在-windows-中信任-ca-证书)
  - [在 Firefox 中信任 CA 证书](#在-firefox-中信任-ca-证书)
- [配置](#配置)
- [故障排除](#故障排除)
  - [SSL 无法生成](#ssl-无法生成)
  - [浏览器显示安全警告](#浏览器显示安全警告)
  - [无法解析主机名](#无法解析主机名)
  - [Apache 无法启动](#apache-无法启动)
  - [创建主机时出现权限错误](#创建主机时出现权限错误)
- [许可证](#许可证)

---

## 描述

Xampp vHosts Manager 是一款简化 Windows 上 Xampp 虚拟主机创建和管理的工具。其主要功能包括：

- 数秒内创建虚拟主机
- 无需使用复杂的 OpenSSL 命令即可生成自签名 SSL 证书
- 通过控制台 (`xvhost`) 或交互式 Web 面板进行管理

该工具专为使用 Xampp 并需要快速、简便地管理多个带有 SSL 的本地域名的开发者而设计。

---

## 功能特性

- 使用自定义名称创建虚拟主机
- 删除现有虚拟主机
- 显示主机的详细信息
- 列出所有虚拟主机
- 为任意主机添加自签名 SSL 证书
- 删除主机的 SSL 证书
- 更改现有主机的 Document Root
- 启动、停止和重启 Apache
- **现代化 Web 面板**，提供深色图形界面
- 可安装为 Windows 受信任实体的自有 CA 证书

---

## 兼容性

- 兼容所有使用 PHP 5.4 或更高版本的 Xampp 版本
- **不支持** Xampp 便携版
- 操作系统：仅限 Windows

---

## 系统要求

1. **已安装 Xampp**（必须）
2. **PHP 可访问** — 安装程序会自动将 Xampp 的 PHP 路径添加到 Windows PATH 环境变量中
3. **可选：** 已安装 Composer（仅当希望从 Composer 安装时需要）

---

## 安装

### 手动下载（推荐）

1. 下载[最新版本](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest)
2. 将内容解压到一个共享位置，例如 `C:\xampp\hosts` 或 `D:\xvhm`
   > **重要提示：** 不要放置在 `C:\Program Files` 或需要管理员权限才能写入文件的位置
3. **以管理员身份**打开终端
4. 导航到解压管理器的目录：
   ```cmd
   cd /D C:\xampp\hosts
   ```
5. 运行安装程序：
   ```cmd
   xvhost install
   ```
6. 按照屏幕提示操作（Xampp 路径、建议的 DocumentRoot 路径等）
7. 关闭终端（以清除临时环境变量）
8. 打开新的终端 — 现在可以在任何位置使用 `xvhost` 命令

### 管理器安装流程

`xvhost install` 命令会自动完成以下操作：

- 将管理器路径注册到 Windows PATH 环境变量中
- 使用 Xampp 路径配置 `settings.ini` 文件
- 在 `cacert/` 目录中生成证书颁发机构（CA）证书
- 为 Windows 的 `hosts` 文件授予必要权限

---

## 更新升级

1. 备份你的 `settings.ini` 文件和 `cacert/` 文件夹
2. 删除管理器目录中的所有内容
3. 下载[最新版本](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest)并解压到同一目录
4. 恢复你的 `settings.ini` 文件和 `cacert/` 文件夹

---

## 控制台命令使用 (xvhost)

安装完成后，可以在任何终端中运行 `xvhost` **无需管理员权限**（修改系统配置的命令除外）。

### 帮助

```
xvhost help
```

### 创建虚拟主机

```
xvhost new [主机名]
```

示例：
```
xvhost new mistio.local
```

> `主机名` 参数是可选的。如果不传入，系统会在过程中提示你输入。

创建过程中会询问以下信息：
- **Document Root** — 网站文件的存放路径
- **管理员邮箱**
- **是否添加 SSL？** — 如果回答是，将自动生成自签名 SSL 证书

### 查看主机信息

```
xvhost show [主机名]
```

示例：
```
xvhost show mistio.local
```

### 列出所有主机

```
xvhost list
```

### 删除主机

```
xvhost remove [主机名]
```

示例：
```
xvhost remove mistio.local
```

这将删除 Apache 配置、SSL（如果存在）以及 Windows `hosts` 文件的条目。

### 添加 SSL 证书

```
xvhost add_ssl [主机名]
```

示例：
```
xvhost add_ssl mistio.local
```

### 删除 SSL 证书

```
xvhost remove_ssl [主机名]
```

### 更改 Document Root

```
xvhost change_docroot [主机名]
```

### 停止/启动/重启 Apache

```
xvhost stop_apache
xvhost start_apache
xvhost restart_apache
```

### 注册应用路径

如果将管理器移动到其他文件夹，可以使用以下命令注册新路径：

```
xvhost register_path
```

> 需要管理员权限。

### Windows hosts 文件权限

为了让管理器能自动向 Windows 的 `hosts` 文件添加条目：

```
xvhost grantperms_winhosts
```

> 需要管理员权限。只需执行一次即可。

---

## Web 面板（图形界面）

除控制台外，该项目还包含一个可通过浏览器访问的**现代化 Web 面板**。

### Web 面板要求

- Apache 与 PHP 正在运行（必须）
- 管理器目录必须在 Apache 的文档树内，或者有指向该目录的虚拟主机

### 如何访问

如果将管理器安装在 `C:\xampp\hosts`，可以通过以下方式访问：

**方式 A — 虚拟主机：** 创建一个指向该目录的虚拟主机：
```
xvhost new xvhm.local
```
当提示输入 Document Root 时，输入 `C:\xampp\hosts`，然后访问 `http://xvhm.local`

**方式 B — 直接使用 PHP：** 打开终端并运行：
```
C:\xampp\php\php.exe -S localhost:8080 -t C:\xampp\hosts
```
然后访问 `http://localhost:8080`

### 面板功能

Web 面板支持以下操作：

- **查看所有虚拟主机**及其 SSL 状态
- **创建新主机**，提供表单输入（名称、Document Root、邮箱、SSL）
- **一键在浏览器中打开主机**
- **直接删除主机**
- **控制 Apache**（启动、停止、重启）
- **实时查看 Apache 状态**
- 深色模式界面设计

---

## SSL 证书

### 工作原理

管理器处理两种类型的证书：

1. **根 CA 证书** (`cacert/cacert.crt`) — 安装期间仅生成一次。它是签署所有虚拟主机证书的证书颁发机构。

2. **主机证书** — 每个启用 SSL 的主机都会收到由其根 CA 签署的独立证书。这些证书包含主机名和 `www.*` 的主题备用名称（SANs）。

**存放位置：**
- CA 证书：`C:\xampp\hosts\cacert\`
- 主机证书：`C:\xampp\apache\conf\extra\certs\`
- 私钥：`C:\xampp\apache\conf\extra\keys\`
- Apache SSL 配置：`C:\xampp\apache\conf\extra\vhosts_ssl\`

### 在 Windows 中信任 CA 证书

要确保浏览器在访问 `https://yoursite.local` 时**不显示安全警告**：

1. **以管理员身份**打开终端
2. 运行：
   ```cmd
   certutil -addstore -f Root C:\xampp\hosts\cacert\cacert.crt
   ```
   （如果管理器安装在其他目录，请调整路径）
3. 重启浏览器

如果使用 **Chrome 或 Edge**，也可以：
- 进入 `chrome://settings/security` → 管理证书 → 导入
- 选择 `C:\xampp\hosts\cacert\cacert.crt`
- 选择"受信任的根证书颁发机构"
- 完成

### 在 Firefox 中信任 CA 证书

Firefox 使用其独立的证书库，与 Windows 的证书库无关：

1. 打开 Firefox
2. 进入 **设置** → **隐私与安全** → **证书**
3. 点击 **查看证书** → **证书颁发机构** 选项卡
4. 点击 **导入**
5. 选择 `C:\xampp\hosts\cacert\cacert.crt`
6. 勾选 **"信任此证书颁发机构以标识网站"**
7. 点击确定

---

## 配置

所有配置均位于管理器目录下的 `settings.ini` 文件中：

```ini
[DirectoryPaths]
; Xampp 安装路径
Xampp = "C:\xampp"

[Suggestions]
; 创建新主机时建议的 DocumentRoot 路径
; {{host_name}} 会被替换为主机名
DocumentRoot = "C:\xampp\hosts\{{host_name}}"

; 建议的 ServerAdmin 邮箱
AdminEmail = "admin@localhost"

[ListViewMode]
; 列出主机时每页显示的记录数
RecordPerPage = "5"
```

---

## 故障排除

### SSL 无法生成

**症状：** 运行 `xvhost add_ssl mistio.local` 时，过程失败，未创建证书。

**原因：** 在早期版本中，证书序列号使用 `php -r "echo md5(...)"` 生成，但 `php` 不在系统 PATH 中。当前版本已修复此问题，改用 `openssl rand -hex 16`。

**解决方案：** 确保使用最新版本的管理器。如果问题仍然存在，请验证 `C:\xampp\apache\bin\openssl.exe` 是否存在。

### 浏览器显示安全警告

**症状：** 打开 `https://mistio.local` 时显示"您的连接不是私密连接"（NET::ERR_CERT_AUTHORITY_INVALID）。

**原因：** SSL 证书由本地 CA 签署，但 Windows/Firefox 不信任该 CA。

**解决方案：** 将 CA 证书安装为受信任实体（请参阅[在 Windows 中信任 CA 证书](#在-windows-中信任-ca-证书)部分）。

### 无法解析主机名

**症状：** `http://mistio.local` 无法加载，显示"找不到服务器"。

**原因：** 主机未添加到 Windows 的 `hosts` 文件中。

**解决方案：** 确保已以管理员身份运行 `xvhost grantperms_winhosts`（仅需一次）。然后使用 `xvhost new mistio.local` 创建主机，或手动将以下内容添加到 `C:\Windows\System32\drivers\etc\hosts`：
```
127.0.0.1   mistio.local
127.0.0.1   www.mistio.local
```

### Apache 无法启动

**症状：** 安装或修改主机后 Apache 无法启动。

**可能的原因及解决方案：**
- **端口被占用：** 其他程序（Skype、IIS、Docker）正在使用 80 或 443 端口。停止该程序或在 `C:\xampp\apache\conf\httpd.conf` 中更改端口
- **语法错误：** 使用以下命令验证：
  ```cmd
  C:\xampp\apache\bin\httpd.exe -t
  ```
- **缺少 OpenSSL：** 确保 `C:\xampp\apache\bin\openssl.exe` 存在
- **SSL 冲突：** 如果 SSL 配置损坏，请检查 `C:\xampp\apache\conf\extra\vhosts_ssl\` 中的文件

### 创建主机时出现权限错误

**症状：** 创建主机或写入 `hosts` 文件时出现"Permission denied"。

**解决方案：** 以管理员身份运行一次：
```
xvhost grantperms_winhosts
```
之后不再需要提升权限即可创建主机。

---

## 许可证

[MIT](LICENSE) © Jose Alexis Correa Valencia
