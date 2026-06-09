# Xampp vHosts Manager

Virtual host and self-signed SSL certificate management system for Xampp on Windows.

**Author:** Jose Alexis Correa Valencia — [jalexiscv@gmail.com](mailto:jalexiscv@gmail.com)
**License:** [MIT](../../LICENSE)
**Changelog:** [changelog/changelog.md](../../changelog/changelog.md)
**Documentation:** [docs/es/](../es/readme.md) • [docs/en/](readme.md)

![Xampp vHosts Manager](https://user-images.githubusercontent.com/9862115/70820328-f78de800-1e0a-11ea-894a-b7021942c158.jpg)

---

## Index

- [Description](#description)
- [Features](#features)
- [Compatibility](#compatibility)
- [Requirements](#requirements)
- [Installation](#installation)
  - [Manual download](#manual-download)
  - [What the installer does](#what-the-installer-does)
- [Updating](#updating)
- [Usage — Console (xvhost)](#usage--console-xvhost)
  - [Help](#help)
  - [Create a virtual host](#create-a-virtual-host)
  - [Show host information](#show-host-information)
  - [List all hosts](#list-all-hosts)
  - [Remove a host](#remove-a-host)
  - [Add an SSL certificate](#add-an-ssl-certificate)
  - [Remove an SSL certificate](#remove-an-ssl-certificate)
  - [Change Document Root](#change-document-root)
  - [Stop/Start/Restart Apache](#stopstartrestart-apache)
  - [Register application path](#register-application-path)
  - [Windows hosts file permissions](#windows-hosts-file-permissions)
- [Web Panel (graphical interface)](#web-panel-graphical-interface)
  - [Web panel requirements](#web-panel-requirements)
  - [How to access](#how-to-access)
  - [Panel features](#panel-features)
- [SSL Certificates](#ssl-certificates)
  - [How it works](#how-it-works)
  - [Trust the CA certificate in Windows](#trust-the-ca-certificate-in-windows)
  - [Trust the CA certificate in Firefox](#trust-the-ca-certificate-in-firefox)
- [Configuration](#configuration)
- [Troubleshooting](#troubleshooting)
  - [SSL is not generated](#ssl-is-not-generated)
  - [Browser shows security warning](#browser-shows-security-warning)
  - [Cannot resolve host name](#cannot-resolve-host-name)
  - [Apache does not start](#apache-does-not-start)
  - [Permission error when creating a host](#permission-error-when-creating-a-host)
- [License](#license)

---

## Description

Xampp vHosts Manager is a tool that simplifies the creation and management of virtual hosts in Xampp for Windows. It allows you to:

- Create virtual hosts in seconds
- Generate self-signed SSL certificates without using complex OpenSSL commands
- Manage everything from the console (`xvhost`) or from an interactive web panel

It is designed for developers who work with Xampp and need multiple local domains with SSL quickly and easily.

---

## Features

- Create virtual hosts with custom names
- Delete existing virtual hosts
- Display detailed information about a host
- List all virtual hosts
- Add self-signed SSL certificates to any host
- Remove SSL certificates from a host
- Change the Document Root of an existing host
- Start, stop, and restart Apache
- **Modern web panel** with a dark graphical interface
- Custom CA certificate that can be installed as a trusted authority in Windows

---

## Compatibility

- Compatible with all Xampp versions using PHP 5.4 or higher
- Does **not** support the portable version of Xampp
- Operating system: Windows only

---

## Requirements

1. **Xampp installed** (obviously)
2. **PHP accessible** — the installer adds the Xampp PHP path automatically to the Windows PATH
3. **Optional:** Composer installed (only if you want to install via Composer)

---

## Installation

### Manual download (recommended)

1. Download the [latest version](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest)
2. Extract the contents to a shared location, for example `C:\xampp\hosts` or `D:\xvhm`
   > **Important:** Do not place it in `C:\Program Files` or locations that require Administrator permissions to write files
3. Open a terminal **as Administrator**
4. Navigate to the directory where you extracted the manager:
   ```cmd
   cd /D C:\xampp\hosts
   ```
5. Run the installer:
   ```cmd
   xvhost install
   ```
6. Follow the on-screen steps (Xampp path, suggested DocumentRoot path, etc.)
7. Exit the terminal (to clear temporary environment variables)
8. Open a new terminal — you can now use `xvhost` from any location

### What the installer does

The `xvhost install` command automatically performs the following:

- Registers the manager path in the Windows PATH environment variables
- Configures the `settings.ini` file with your Xampp paths
- Generates the Certificate Authority (CA) certificate in `cacert/`
- Grants necessary permissions over the Windows `hosts` file

---

## Updating

1. Back up your `settings.ini` file and the `cacert/` folder
2. Delete all contents of the manager directory
3. Download the [latest version](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest) and extract it in the same directory
4. Restore your `settings.ini` file and the `cacert/` folder

---

## Usage — Console (xvhost)

Once installed, you can run `xvhost` from any terminal **without needing Administrator privileges** (except for commands that modify system configuration).

### Help

```
xvhost help
```

### Create a virtual host

```
xvhost new [HOST_NAME]
```

Example:
```
xvhost new mysite.local
```

> The `HOST_NAME` parameter is optional. If you don't provide it, you will be prompted to enter it during the process.

During creation you will be asked for:
- **Document Root** — path where the site files will be located
- **Admin email**
- **Add SSL?** — if you answer yes, a self-signed SSL certificate will be generated automatically

### Show host information

```
xvhost show [HOST_NAME]
```

Example:
```
xvhost show mysite.local
```

### List all hosts

```
xvhost list
```

### Remove a host

```
xvhost remove [HOST_NAME]
```

Example:
```
xvhost remove mysite.local
```

This removes the Apache configuration, the SSL (if it exists), and the entry from the Windows `hosts` file.

### Add an SSL certificate

```
xvhost add_ssl [HOST_NAME]
```

Example:
```
xvhost add_ssl mysite.local
```

### Remove an SSL certificate

```
xvhost remove_ssl [HOST_NAME]
```

### Change Document Root

```
xvhost change_docroot [HOST_NAME]
```

### Stop/Start/Restart Apache

```
xvhost stop_apache
xvhost start_apache
xvhost restart_apache
```

### Register application path

If you move the manager to another folder, you can register the new path with:

```
xvhost register_path
```

> Requires Administrator privileges.

### Windows hosts file permissions

For the manager to automatically add entries to the Windows `hosts` file:

```
xvhost grantperms_winhosts
```

> Requires Administrator privileges. Only needs to be run once.

---

## Web Panel (graphical interface)

In addition to the console, the project includes a **modern web panel** accessible from your browser.

### Web panel requirements

- Apache with PHP running (obviously)
- The manager directory must be inside Apache's document tree, or have a virtual host pointing to it

### How to access

If you installed the manager in `C:\xampp\hosts`, you can:

**Option A — Virtual host:** Create a virtual host pointing to the directory:
```
xvhost new xvhm.local
```
When prompted for the Document Root, enter `C:\xampp\hosts` and visit `http://xvhm.local`

**Option B — Directly with PHP:** Open a terminal and run:
```
C:\xampp\php\php.exe -S localhost:8080 -t C:\xampp\hosts
```
Then visit `http://localhost:8080`

### Panel features

The web panel allows you to:

- **View all virtual hosts** with their SSL status
- **Create new hosts** with a form (name, Document Root, email, SSL)
- **Open hosts** in the browser with one click
- **Delete hosts** directly
- **Control Apache** (start, stop, restart)
- **View Apache status** in real time
- Dark mode interface

---

## SSL Certificates

### How it works

The manager handles two types of certificates:

1. **Root CA certificate** (`cacert/cacert.crt`) — Generated once during installation. It is the Certificate Authority that signs all virtual host certificates.

2. **Host certificates** — Each host with SSL enabled receives its own certificate signed by the root CA. The certificates include Subject Alternative Names (SANs) for the host name and `www.*`.

**Locations:**
- CA certificates: `C:\xampp\hosts\cacert\`
- Host certificates: `C:\xampp\apache\conf\extra\certs\`
- Private keys: `C:\xampp\apache\conf\extra\keys\`
- Apache SSL configurations: `C:\xampp\apache\conf\extra\vhosts_ssl\`

### Trust the CA certificate in Windows

To prevent the browser from **showing security warnings** when accessing `https://yoursite.local`:

1. Open a terminal **as Administrator**
2. Run:
   ```cmd
   certutil -addstore -f Root C:\xampp\hosts\cacert\cacert.crt
   ```
   (adjust the path if you installed the manager in another directory)
3. Restart your browser

If you use **Chrome or Edge**, you can also:
- Go to `chrome://settings/security` → Manage certificates → Import
- Select `C:\xampp\hosts\cacert\cacert.crt`
- Choose "Trusted Root Certification Authorities"
- Finish

### Trust the CA certificate in Firefox

Firefox uses its own certificate store, independent from Windows:

1. Open Firefox
2. Go to **Settings** → **Privacy & Security** → **Certificates**
3. Click **View certificates** → **Authorities** tab
4. Click **Import**
5. Select `C:\xampp\hosts\cacert\cacert.crt`
6. Check **"Trust this CA to identify websites"**
7. OK

---

## Configuration

All configuration is stored in the `settings.ini` file inside the manager directory:

```ini
[DirectoryPaths]
; Path to your Xampp installation
Xampp = "C:\xampp"

[Suggestions]
; Suggested DocumentRoot path when creating a new host
; {{host_name}} is replaced by the host name
DocumentRoot = "C:\xampp\hosts\{{host_name}}"

; Suggested ServerAdmin email
AdminEmail = "admin@localhost"

[ListViewMode]
; Number of records shown per page when listing hosts
RecordPerPage = "5"
```

---

## Troubleshooting

### SSL is not generated

**Symptom:** When running `xvhost add_ssl mysite.local`, the process fails without creating the certificate.

**Cause:** In previous versions, the certificate serial number was generated with `php -r "echo md5(...)"` but `php` was not in the system PATH. The current version fixes this by using `openssl rand -hex 16`.

**Solution:** Make sure you have the latest version of the manager. If the problem persists, verify that `C:\xampp\apache\bin\openssl.exe` exists.

### Browser shows security warning

**Symptom:** When opening `https://mysite.local` you get "Your connection is not private" (NET::ERR_CERT_AUTHORITY_INVALID).

**Cause:** The SSL certificate is signed by the local CA, but Windows/Firefox does not trust it.

**Solution:** Install the CA certificate as a trusted authority (see [Trust the CA certificate in Windows](#trust-the-ca-certificate-in-windows)).

### Cannot resolve host name

**Symptom:** `http://mysite.local` does not load, "Server not found".

**Cause:** The host is not in the Windows `hosts` file.

**Solution:** Make sure you ran `xvhost grantperms_winhosts` as Administrator (only once). Then create the host with `xvhost new mysite.local` or add the following manually:
```
127.0.0.1   mysite.local
127.0.0.1   www.mysite.local
```
to `C:\Windows\System32\drivers\etc\hosts`

### Apache does not start

**Symptom:** Apache fails to start after installing or modifying a host.

**Possible causes and solutions:**
- **Port in use:** Another program (Skype, IIS, Docker) is using port 80 or 443. Stop that program or change the ports in `C:\xampp\apache\conf\httpd.conf`
- **Syntax error:** Check with:
  ```cmd
  C:\xampp\apache\bin\httpd.exe -t
  ```
- **OpenSSL missing:** Make sure `C:\xampp\apache\bin\openssl.exe` exists
- **SSL conflicts:** If there are corrupted SSL configurations, check the files in `C:\xampp\apache\conf\extra\vhosts_ssl\`

### Permission error when creating a host

**Symptom:** "Permission denied" when creating a host or writing to the `hosts` file.

**Solution:** Run once:
```
xvhost grantperms_winhosts
```
as Administrator. You will no longer need elevated permissions to create hosts afterwards.

---

## License

[MIT](../../LICENSE) © Jose Alexis Correa Valencia
