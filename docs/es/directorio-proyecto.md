# Directorio de Proyecto (Hosting) separado del Directorio de Ejecución

A partir de la versión **v1.1.0**, xvhost permite definir **dos directorios diferentes** al crear un host virtual. Esto está diseñado para frameworks como **CodeIgniter 4, Laravel, Symfony** y otros que separan los archivos públicos del código fuente.

## Concepto

| Término | Descripción | Ejemplo CI4 |
|---------|-------------|-------------|
| **Directorio de hostpedaje** (project root / hosting dir) | Raíz del proyecto donde viven TODOS los archivos de la aplicación | `C:\xampp\htdocs\miapp` |
| **Directorio de ejecución** (DocumentRoot / execution dir) | Lo que Apache sirve al navegador (carpeta pública) | `C:\xampp\htdocs\miapp\public` |

## Cómo funciona

Al ejecutar `xvhost new`, después de preguntar por el DocumentRoot, aparece una nueva pregunta:

```
Do you want to set a separate project root directory? (for CodeIgniter 4, Laravel, Symfony) [y|N]:
```

- Si respondes **N** (por defecto): el comportamiento es el mismo de siempre, un solo directorio.
- Si respondes **Y**: se te pedirá el **directorio raíz del proyecto** y el DocumentRoot se ajusta automáticamente.

### Ejemplo con CodeIgniter 4

```
$ xvhost new micuatro.local
Enter the path to document root for this host ["C:\xampp\hosts\micuatro"]:
Do you want to set a separate project root directory? (for CodeIgniter 4, Laravel, Symfony) [y|N]: y
Enter the project root (hosting directory) for this host ["C:\xampp\hosts\micuatro"]:
```

Esto genera un virtualhost con:

```apache
<VirtualHost *:80>
    ServerName micuatro.local
    DocumentRoot "C:/xampp/hosts/micuatro/public"
    <Directory "C:/xampp/hosts/micuatro/public">
        ...
    </Directory>
    SetEnv PROJECT_ROOT "C:/xampp/hosts/micuatro"
</VirtualHost>
```

La directiva `SetEnv PROJECT_ROOT` permite que tu aplicación PHP acceda a la raíz del proyecto mediante `$_SERVER['PROJECT_ROOT']`.

### Subdirectorio público preconfigurado

Puedes configurar un subdirectorio público por defecto en `settings.ini`:

```ini
[Suggestions]
PublicSubDir = "public"
```

Con esta configuración, al responder **Y** a la pregunta de proyecto separado, el DocumentRoot se calcula automáticamente como `{projectRoot}\{PublicSubDir}`. Para CI4 el valor recomendado es `public`; para proyectos tradicionales puedes usar `public_html` o dejarlo vacío.

## Variables de entorno

El virtualhost generado incluye:

| Variable | Propósito | Ejemplo |
|----------|-----------|---------|
| `PROJECT_ROOT` | Ruta absoluta del directorio raíz del proyecto | `C:/xampp/hosts/micuatro` |

Disponible en PHP como `$_SERVER['PROJECT_ROOT']`.

## Notas importantes

- Si el directorio de proyecto y el DocumentRoot son el mismo (respondiste **N**), no se añade `SetEnv PROJECT_ROOT`.
- El cambio de DocumentRoot mediante `xvhost change_docroot` actualiza el DocumentRoot pero preserva el PROJECT_ROOT existente en el archivo de configuración.
- El SSL (`xvhost add_ssl`) también incluye `SetEnv PROJECT_ROOT` en la configuración SSL.
