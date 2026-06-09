# Convención de nombres del proyecto

Este documento explica por qué el proyecto usa la convención de nombres actual y qué problema resuelve.

---

## El problema

Antes de la estandarización, el proyecto mezclaba múltiples estilos de nomenclatura sin criterio definido:

| Ejemplo | Estilo usado |
|---------|-------------|
| `CHANGELOGS/` | `UPPERCASE` |
| `src/` | `lowercase` |
| `src/Support/` | `PascalCase` |
| `README_vi.md` | `snake_case` |
| `pre_defined.php` | `snake_case` |
| `xvhost.hlp` | `.hlp` (extensión no estándar) |

Esto generaba varios problemas:

- **Inconsistencia visual:** Cada directorio y archivo usaba un estándar distinto, dificultando la navegación
- **Falta de predictibilidad:** Un desarrollador no podía anticipar cómo se llamaba un archivo o directorio
- **Dificultad para automatizar:** Scripts de búsqueda, linting o generación de índices requerían manejar múltiples patrones
- **Fricción en code review:** Discutir sobre naming agrega ruido a revisiones de código

---

## La solución: dos estándares según el contexto

No existe un "único estándar correcto" para todos los archivos de un proyecto. La decisión fue separar en dos categorías:

### 1. kebab-case — para archivos y directorios no-PHP

**Regla:** minúsculas + guiones (`mi-archivo.md`, `mi-directorio/`)

**¿Por qué kebab-case y no snake_case o camelCase?**

| Razón | Explicación |
|-------|-------------|
| **URL-friendly** | Los guiones son el estándar en URLs. Un archivo `mi-documento.md` se traduce naturalmente a `/docs/mi-documento` |
| **GitHub lo reconoce** | GitHub usa kebab-case por defecto para sus archivos (`README.md`, `CONTRIBUTING.md`) |
| **CLI amigable** | Es el estándar en comandos de terminal: `git log --oneline`, `npm install --save-dev` |
| **PHP-FIG lo recomienda** | Aunque PSR-4 no define naming para archivos no-PHP, PHP-FIG recomienda kebab-case para archivos de proyecto |
| **Sin ambigüedad** | A diferencia de snake_case (confundible con variables PHP) o camelCase (confundible con métodos), kebab-case es inequívoco |
| **Amplio ecosistema** | Laravel, Symfony, Vue, Svelte, Astro — todos usan kebab-case para archivos de proyecto |

### 2. PascalCase — para namespaces y clases PHP (PSR-4)

**Regla:** Primera letra mayúscula, sin separadores (`Support/`, `Application.php`)

**¿Por qué PascalCase para PSR-4?**

PSR-4 (PHP Standards Recommendation 4) define que el namespace de una clase debe mapearse directamente a la estructura de directorios:

```
Namespace: VhostsManager\Support\Application
Directorio: src/Support/Application.php
```

PascalCase es **obligatorio** porque:
- Los namespaces en PHP usan PascalCase por convención (PSR-1, PSR-4)
- El autoloader de Composer resuelve `VhostsManager\Support\Application` buscando `src/Support/Application.php`
- Cambiar `Support/` a `support/` rompería el autoloading

### 3. Excepciones — archivos con nombre fijo por ecosistema

Algunos archivos **deben** conservar su nombre específico porque herramientas externas los reconocen así:

| Archivo | Estándar | Herramienta que lo exige |
|---------|----------|------------------------|
| `README.md` | `UPPERCASE` | GitHub (lo renderiza en la página del repo) |
| `LICENSE` | `UPPERCASE` | GitHub (lo muestra en la barra lateral) |
| `composer.json` | `lowercase` | Composer (no reconoce `Composer.json`) |
| `.gitignore` | `lowercase` | Git (nombre fijo) |

---

## Árbol resultante

```
xampp-hosts/
├── changelog/              ← kebab-case
│   └── changelog.md
├── docs/                   ← kebab-case
│   ├── readme.md
│   ├── es/
│   │   ├── readme.md
│   │   └── estandarizacion.md
│   └── en/
│       └── readme.md
├── src/                    ← kebab-case
│   ├── Support/            ← PascalCase (PSR-4)
│   ├── Templates/          ← PascalCase (PSR-4 style)
│   ├── Tools/              ← PascalCase (PSR-4 style)
│   ├── helpers.php
│   ├── predefined.php
│   └── xvhost.php
├── api.php                 ← kebab-case
├── index.php
├── README.md               ← estándar GitHub
├── README.vi.md            ← dot notation
├── xvhost.bat
├── xvhost.help.txt         ← extensión .txt estándar
├── LICENSE                 ← estándar GitHub
├── composer.json           ← estándar Composer
├── settings.ini
└── .gitignore
```

---

## Preguntas frecuentes

### ¿Por qué no usar un solo estándar para todo?

Porque no existe un estándar único que cubra todos los tipos de archivo. Intentar forzar PascalCase en `composer.json` rompería Composer. Forzar kebab-case en `Support/` rompería PSR-4. La segmentación por contexto es pragmática, no dogmática.

### ¿Qué pasa con los archivos nuevos?

| Si el archivo es... | Usa... |
|--------------------|--------|
| Una clase PHP con namespace | PascalCase |
| Un archivo de configuración | kebab-case |
| Documentación | kebab-case |
| Un script .bat/.sh | kebab-case |
| `composer.json`, `README.md`, etc. | Su estándar de ecosistema |

### ¿Esto sigue PSR-12?

PSR-12 (estilo de codificación PHP) y PSR-4 (autoloading) se cumplen en todo el código PHP (`src/`). Para archivos fuera de `src/`, PSR-12/PSR-4 no aplican, y se usa kebab-case como estándar general del proyecto.

---

## Referencias

- [PSR-1: Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
- [PSR-4: Autoloader](https://www.php-fig.org/psr/psr-4/)
- [PSR-12: Extended Coding Style](https://www.php-fig.org/psr/psr-12/)
- [PHP-FIG naming recommendations](https://www.php-fig.org/bylaws/psr-naming-conventions/)
- [Keep a Changelog](https://keepachangelog.com/es/1.1.0/) (formato de changelog)
