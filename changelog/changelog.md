# Registro de cambios / Changelog

Todas las modificaciones importantes de Xampp vHosts Manager se documentan aquí.

Formato basado en [Keep a Changelog](https://keepachangelog.com/es/1.1.0/).

---

## [1.0.0] — 2026-06-09

### Añadido
- Panel web moderno con interfaz oscura (`index.php` + `api.php`)
- Gestión visual de hosts virtuales (crear, eliminar, listar)
- Control de Apache desde el navegador (iniciar, detener, reiniciar)
- Vista de estado de Apache en tiempo real
- Documentación completa en español (README.md, xvhost.help.txt)
- Directorio `docs/` para documentación adicional
- Directorio `changelog/` para registro de cambios

### Cambiado
- Créditos del proyecto actualizados a Jose Alexis Correa Valencia <jalexiscv@gmail.com>
- Banner de CLI traducido al español
- Enlaces del README actualizados al nuevo repositorio
- Nombre del paquete en `composer.json` actualizado
- Estandarización de nombres: kebab-case para archivos/dirs no-PHP, PascalCase para PSR-4
  - `CHANGELOGS/` → `changelog/`
  - `README_vi.md` → `README.vi.md`
  - `xvhost.hlp` → `xvhost.help.txt`
  - `docs/README.md` → `docs/readme.md`

### Corregido
- **Generación SSL:** El serial number del certificado ahora se genera con `openssl rand -hex 16` en lugar de `php -r "echo md5(...)"`, lo que evita fallos cuando PHP no está en el PATH del sistema
- Archivo `serial.txt` ya no queda vacío, permitiendo que `openssl ca` firme correctamente los certificados

---

## [0.1.0] — 2019 (Original de Jackie Do)

### Añadido
- Sistema de gestión de hosts virtuales para Xampp en Windows
- Creación y eliminación de hosts virtuales
- Generación de certificados SSL autofirmados
- Comandos de consola: `xvhost new`, `remove`, `list`, `show`, `add_ssl`, `remove_ssl`, etc.
- Certificado de Autoridad Certificadora (CA) propio
- Instalación automatizada con registro en PATH de Windows
- Soporte para múltiples hosts con Document Roots personalizados
