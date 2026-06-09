# Xampp vHosts Manager

Sistema de gestión de hosts virtuales y certificados SSL autofirmados para Xampp en Windows.

**Autor:** Jose Alexis Correa Valencia — [jalexiscv@gmail.com](mailto:jalexiscv@gmail.com)
**Licencia:** [MIT](LICENSE)
**Changelog:** [changelog/changelog.md](changelog/changelog.md)
**Documentación:** [Español](docs/es/readme.md) • [English](docs/en/readme.md) • [Français](docs/fr/readme.md) • [Português](docs/pt/readme.md) • [Deutsch](docs/de/readme.md) • [简体中文](docs/zh-CN/readme.md) • [日本語](docs/ja/readme.md) • [Русский](docs/ru/readme.md)

![Xampp vHosts Manager](https://user-images.githubusercontent.com/9862115/70820328-f78de800-1e0a-11ea-894a-b7021942c158.jpg)

---

## Índice

- [Descripción](#descripción)
- [Características](#características)
- [Compatibilidad](#compatibilidad)
- [Requisitos](#requisitos)
- [Instalación](#instalación)
  - [Descarga manual](#descarga-manual)
  - [Instalación del gestor](#instalación-del-gestor)
- [Actualización](#actualización)
- [Uso — Consola (xvhost)](#uso--consola-xvhost)
  - [Ayuda](#ayuda)
  - [Crear un host virtual](#crear-un-host-virtual)
  - [Ver información de un host](#ver-información-de-un-host)
  - [Listar todos los hosts](#listar-todos-los-hosts)
  - [Eliminar un host](#eliminar-un-host)
  - [Agregar certificado SSL](#agregar-certificado-ssl)
  - [Eliminar certificado SSL](#eliminar-certificado-ssl)
  - [Cambiar Document Root](#cambiar-document-root)
  - [Detener/Iniciar/Reiniciar Apache](#deteneriniciarreiniciar-apache)
  - [Registrar ruta de la aplicación](#registrar-ruta-de-la-aplicación)
  - [Permisos del archivo hosts de Windows](#permisos-del-archivo-hosts-de-windows)
- [Panel Web (interfaz gráfica)](#panel-web-interfaz-gráfica)
  - [Requisitos del panel web](#requisitos-del-panel-web)
  - [Cómo acceder](#cómo-acceder)
  - [Funciones del panel](#funciones-del-panel)
- [Certificados SSL](#certificados-ssl)
  - [¿Cómo funciona?](#cómo-funciona)
  - [Confiar el certificado CA en Windows](#confiar-el-certificado-ca-en-windows)
  - [Confiar el certificado CA en Firefox](#confiar-el-certificado-ca-en-firefox)
- [Configuración](#configuración)
- [Solución de problemas](#solución-de-problemas)
  - [El SSL no se genera](#el-ssl-no-se-genera)
  - [El navegador muestra advertencia de seguridad](#el-navegador-muestra-advertencia-de-seguridad)
  - [No se puede resolver el nombre del host](#no-se-puede-resolver-el-nombre-del-host)
  - [Apache no inicia](#apache-no-inicia)
  - [Error de permisos al crear host](#error-de-permisos-al-crear-host)
- [Licencia](#licencia)

---

## Descripción

Xampp vHosts Manager es una herramienta que facilita la creación y gestión de hosts virtuales en Xampp para Windows. Permite:

- Crear hosts virtuales en segundos
- Generar certificados SSL autofirmados sin usar comandos complejos de OpenSSL
- Administrar todo desde la consola (`xvhost`) o desde un panel web interactivo

Está diseñado para desarrolladores que trabajan con Xampp y necesitan múltiples dominios locales con SSL de forma rápida y sencilla.

---

## Características

- Crear hosts virtuales con nombre personalizado
- Eliminar hosts virtuales existentes
- Mostrar información detallada de un host
- Listar todos los hosts virtuales
- Agregar certificados SSL autofirmados a cualquier host
- Eliminar certificados SSL de un host
- Cambiar el Document Root de un host existente
- Iniciar, detener y reiniciar Apache
- **Panel web** moderno con interfaz gráfica oscura
- Certificado CA propio que se puede instalar como entidad de confianza en Windows

---

## Compatibilidad

- Compatible con todas las versiones de Xampp que usen PHP 5.4 o superior
- **No** soporta la versión portable de Xampp
- Sistema operativo: Windows únicamente

---

## Requisitos

1. **Xampp instalado** (obviamente)
2. **PHP** accesible — el instalador agrega la ruta de PHP de Xampp automáticamente al PATH de Windows
3. **Opcional:** Composer instalado (solo si deseas instalar desde Composer)

---

## Instalación

### Descarga manual (recomendada)

1. Descarga la [última versión](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest)
2. Extrae el contenido en una ubicación compartida, por ejemplo `C:\xampp\hosts` o `D:\xvhm`
   > **Importante:** No lo coloques en `C:\Program Files` ni en ubicaciones que requieran permisos de Administrador para escribir archivos
3. Abre una terminal **como Administrador**
4. Navega hasta el directorio donde extrajiste el gestor:
   ```cmd
   cd /D C:\xampp\hosts
   ```
5. Ejecuta el instalador:
   ```cmd
   xvhost install
   ```
6. Sigue los pasos en pantalla (ruta de Xampp, ruta de DocumentRoot sugerida, etc.)
7. Sal de la terminal (para limpiar variables de entorno temporales)
8. Abre una nueva terminal — ahora puedes usar `xvhost` desde cualquier ubicación

### Instalación del gestor

El comando `xvhost install` realiza automáticamente:

- Registra la ruta del gestor en las variables de entorno PATH de Windows
- Configura el archivo `settings.ini` con las rutas de tu Xampp
- Genera el certificado de Autoridad Certificadora (CA) en `cacert/`
- Concede permisos necesarios sobre el archivo `hosts` de Windows

---

## Actualización

1. Respalda tu archivo `settings.ini` y la carpeta `cacert/`
2. Elimina todo el contenido del directorio del gestor
3. Descarga la [última versión](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest) y extráela en el mismo directorio
4. Restaura tu archivo `settings.ini` y la carpeta `cacert/`

---

## Uso — Consola (xvhost)

Una vez instalado, puedes ejecutar `xvhost` desde cualquier terminal **sin necesidad de ser Administrador** (excepto los comandos que modifican configuración del sistema).

### Ayuda

```
xvhost help
```

### Crear un host virtual

```
xvhost new [NOMBRE_HOST]
```

Ejemplo:
```
xvhost new mistio.local
```

> El parámetro `NOMBRE_HOST` es opcional. Si no lo pasas, se te pedirá ingresarlo durante el proceso.

Durante la creación se te preguntará:
- **Document Root** — ruta donde estarán los archivos del sitio
- **Email del administrador**
- **¿Agregar SSL?** — si respondes que sí, se generará automáticamente un certificado SSL autofirmado

### Ver información de un host

```
xvhost show [NOMBRE_HOST]
```

Ejemplo:
```
xvhost show mistio.local
```

### Listar todos los hosts

```
xvhost list
```

### Eliminar un host

```
xvhost remove [NOMBRE_HOST]
```

Ejemplo:
```
xvhost remove mistio.local
```

Esto elimina la configuración de Apache, el SSL (si existe) y la entrada del archivo `hosts` de Windows.

### Agregar certificado SSL

```
xvhost add_ssl [NOMBRE_HOST]
```

Ejemplo:
```
xvhost add_ssl mistio.local
```

### Eliminar certificado SSL

```
xvhost remove_ssl [NOMBRE_HOST]
```

### Cambiar Document Root

```
xvhost change_docroot [NOMBRE_HOST]
```

### Detener/Iniciar/Reiniciar Apache

```
xvhost stop_apache
xvhost start_apache
xvhost restart_apache
```

### Registrar ruta de la aplicación

Si mueves el gestor a otra carpeta, puedes registrar la nueva ruta con:

```
xvhost register_path
```

> Requiere permisos de Administrador.

### Permisos del archivo hosts de Windows

Para que el gestor pueda agregar entradas al archivo `hosts` de Windows automáticamente:

```
xvhost grantperms_winhosts
```

> Requiere permisos de Administrador. Solo es necesario ejecutarlo una vez.

---

## Panel Web (interfaz gráfica)

Además de la consola, el proyecto incluye un **panel web moderno** accesible desde el navegador.

### Requisitos del panel web

- Apache con PHP corriendo (obviamente)
- El directorio del gestor debe estar dentro del árbol de documentos de Apache, o tener un host virtual apuntando a él

### Cómo acceder

Si instalaste el gestor en `C:\xampp\hosts`, puedes:

**Opción A — Host virtual:** Crea un host virtual que apunte al directorio:
```
xvhost new xvhm.local
```
Cuando pida el Document Root, ingresa `C:\xampp\hosts` y visita `http://xvhm.local`

**Opción B — Directamente con PHP:** Abre una terminal y ejecuta:
```
C:\xampp\php\php.exe -S localhost:8080 -t C:\xampp\hosts
```
Luego visita `http://localhost:8080`

### Funciones del panel

El panel web permite:

- **Ver todos los hosts virtuales** con su estado SSL
- **Crear hosts nuevos** con formulario (nombre, Document Root, email, SSL)
- **Abrir hosts** en el navegador con un clic
- **Eliminar hosts** directamente
- **Controlar Apache** (iniciar, detener, reiniciar)
- **Ver el estado** de Apache en tiempo real
- Interfaz con diseño oscuro (dark mode)

---

## Certificados SSL

### ¿Cómo funciona?

El gestor maneja dos tipos de certificados:

1. **Certificado CA raíz** (`cacert/cacert.crt`) — Se genera una sola vez durante la instalación. Es la Autoridad Certificadora que firma todos los certificados de los hosts virtuales.

2. **Certificados de hosts** — Cada host que habilita SSL recibe su propio certificado firmado por la CA raíz. Los certificados incluyen Subject Alternative Names (SANs) para el nombre del host y `www.*`.

**Ubicaciones:**
- Certificados CA: `C:\xampp\hosts\cacert\`
- Certificados de hosts: `C:\xampp\apache\conf\extra\certs\`
- Llaves privadas: `C:\xampp\apache\conf\extra\keys\`
- Configuraciones SSL de Apache: `C:\xampp\apache\conf\extra\vhosts_ssl\`

### Confiar el certificado CA en Windows

Para que el navegador **no muestre advertencias de seguridad** al acceder a `https://tusitio.local`:

1. Abre una terminal **como Administrador**
2. Ejecuta:
   ```cmd
   certutil -addstore -f Root C:\xampp\hosts\cacert\cacert.crt
   ```
   (ajusta la ruta si instalaste el gestor en otro directorio)
3. Reinicia el navegador

Si usas **Chrome o Edge**, también puedes:
- Ir a `chrome://settings/security` → Administrar certificados → Importar
- Seleccionar `C:\xampp\hosts\cacert\cacert.crt`
- Elegir "Entidades de certificación raíz de confianza"
- Finalizar

### Confiar el certificado CA en Firefox

Firefox usa su propio almacén de certificados, independiente del de Windows:

1. Abre Firefox
2. Ve a **Configuración** → **Privacidad y Seguridad** → **Certificados**
3. Haz clic en **Ver certificados** → pestaña **Entidades**
4. Clic en **Importar**
5. Selecciona `C:\xampp\hosts\cacert\cacert.crt`
6. Marca **"Confiar en esta entidad certificadora para identificar sitios web"**
7. Aceptar

---

## Configuración

Toda la configuración se encuentra en el archivo `settings.ini` dentro del directorio del gestor:

```ini
[DirectoryPaths]
; Ruta de tu instalación de Xampp
Xampp = "C:\xampp"

[Suggestions]
; Ruta sugerida como DocumentRoot al crear un nuevo host
; {{host_name}} se reemplaza por el nombre del host
DocumentRoot = "C:\xampp\hosts\{{host_name}}"

; Email sugerido como ServerAdmin
AdminEmail = "admin@localhost"

[ListViewMode]
; Número de registros mostrados por página al listar hosts
RecordPerPage = "5"
```

---

## Solución de problemas

### El SSL no se genera

**Síntoma:** Al ejecutar `xvhost add_ssl mistio.local`, el proceso falla sin crear el certificado.

**Causa:** En versiones anteriores, el serial number del certificado se generaba con `php -r "echo md5(...)"` pero `php` no estaba en el PATH del sistema. La versión actual corrige esto usando `openssl rand -hex 16`.

**Solución:** Asegúrate de tener la versión más reciente del gestor. Si el problema persiste, verifica que `C:\xampp\apache\bin\openssl.exe` exista.

### El navegador muestra advertencia de seguridad

**Síntoma:** Al abrir `https://mistio.local` aparece "Su conexión no es privada" (NET::ERR_CERT_AUTHORITY_INVALID).

**Causa:** El certificado SSL está firmado por la CA local, pero Windows/Firefox no confía en ella.

**Solución:** Instala el certificado CA como entidad de confianza (ver sección [Confiar el certificado CA en Windows](#confiar-el-certificado-ca-en-windows)).

### No se puede resolver el nombre del host

**Síntoma:** `http://mistio.local` no carga, "No se pudo encontrar el servidor".

**Causa:** El host no está en el archivo `hosts` de Windows.

**Solución:** Asegúrate de haber ejecutado `xvhost grantperms_winhosts` como Administrador (solo una vez). Luego crea el host con `xvhost new mistio.local` o agrega manualmente:
```
127.0.0.1   mistio.local
127.0.0.1   www.mistio.local
```
en `C:\Windows\System32\drivers\etc\hosts`

### Apache no inicia

**Síntoma:** Apache no arranca después de instalar o modificar un host.

**Posibles causas y soluciones:**
- **Puerto en uso:** Otro programa (Skype, IIS, Docker) está usando el puerto 80 u 443. Detén ese programa o cambia los puertos en `C:\xampp\apache\conf\httpd.conf`
- **Error de sintaxis:** Verifica con:
  ```cmd
  C:\xampp\apache\bin\httpd.exe -t
  ```
- **Falta OpenSSL:** Asegúrate de que `C:\xampp\apache\bin\openssl.exe` exista
- **Conflictos de SSL:** Si hay configuraciones SSL corruptas, revisa los archivos en `C:\xampp\apache\conf\extra\vhosts_ssl\`

### Error de permisos al crear host

**Síntoma:** "Permission denied" al crear un host o al escribir en el archivo `hosts`.

**Solución:** Ejecuta una vez:
```
xvhost grantperms_winhosts
```
como Administrador. Luego ya no necesitarás permisos elevados para crear hosts.

---

## Licencia

[MIT](LICENSE) © Jose Alexis Correa Valencia
