# Project Root (Hosting) Separate from Execution Directory

As of version **v1.1.0**, xvhost supports defining **two separate directories** when creating a virtual host. This is designed for frameworks like **CodeIgniter 4, Laravel, Symfony** and others that separate public files from source code.

## Concept

| Term | Description | CI4 Example |
|------|-------------|-------------|
| **Hosting directory** (project root) | Project root where ALL app files live | `C:\xampp\htdocs\myapp` |
| **Execution directory** (DocumentRoot) | What Apache serves to the browser (public folder) | `C:\xampp\htdocs\myapp\public` |

## How it works

When running `xvhost new`, after asking for DocumentRoot, a new prompt appears:

```
Do you want to set a separate project root directory? (for CodeIgniter 4, Laravel, Symfony) [y|N]:
```

- Answer **N** (default): behavior is the same as before — single directory.
- Answer **Y**: you'll be prompted for the **project root directory** and the DocumentRoot is adjusted automatically.

### CodeIgniter 4 example

```
$ xvhost new myci4.local
Enter the path to document root for this host ["C:\xampp\hosts\myci4"]:
Do you want to set a separate project root directory? (for CodeIgniter 4, Laravel, Symfony) [y|N]: y
Enter the project root (hosting directory) for this host ["C:\xampp\hosts\myci4"]:
```

This generates a virtual host with:

```apache
<VirtualHost *:80>
    ServerName myci4.local
    DocumentRoot "C:/xampp/hosts/myci4/public"
    <Directory "C:/xampp/hosts/myci4/public">
        ...
    </Directory>
    SetEnv PROJECT_ROOT "C:/xampp/hosts/myci4"
</VirtualHost>
```

The `SetEnv PROJECT_ROOT` directive lets your PHP application access the project root via `$_SERVER['PROJECT_ROOT']`.

### Preconfigured public subdirectory

You can set a default public subdirectory in `settings.ini`:

```ini
[Suggestions]
PublicSubDir = "public"
```

With this setting, when answering **Y** to the separate project root prompt, the DocumentRoot is automatically calculated as `{projectRoot}\{PublicSubDir}`. For CI4 use `public`; for traditional projects use `public_html` or leave it empty.

## Environment variables

The generated virtual host includes:

| Variable | Purpose | Example |
|----------|---------|---------|
| `PROJECT_ROOT` | Absolute path to project root directory | `C:/xampp/hosts/myci4` |

Available in PHP as `$_SERVER['PROJECT_ROOT']`.

## Important notes

- If the project root and DocumentRoot are the same (you answered **N**), `SetEnv PROJECT_ROOT` is not added.
- Changing DocumentRoot via `xvhost change_docroot` updates the DocumentRoot but preserves the existing PROJECT_ROOT in the config file.
- SSL (`xvhost add_ssl`) also includes `SetEnv PROJECT_ROOT` in the SSL configuration.
