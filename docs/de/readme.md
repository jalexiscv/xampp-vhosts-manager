# Xampp vHosts Manager

Verwaltungssystem für virtuelle Hosts und selbstsignierte SSL-Zertifikate für Xampp unter Windows.

**Autor:** Jose Alexis Correa Valencia — [jalexiscv@gmail.com](mailto:jalexiscv@gmail.com)
**Lizenz:** [MIT](LICENSE)
**Changelog:** [changelog/changelog.md](../../changelog/changelog.md)
**Dokumentation:** [docs/de/](readme.md) (Deutsch) • [docs/es/](../es/readme.md) (Spanisch) • [docs/en/](../en/readme.md) (Englisch)

![Xampp vHosts Manager](https://user-images.githubusercontent.com/9862115/70820328-f78de800-1e0a-11ea-894a-b7021942c158.jpg)

---

## Inhaltsverzeichnis

- [Beschreibung](#beschreibung)
- [Funktionen](#funktionen)
- [Kompatibilität](#kompatibilität)
- [Voraussetzungen](#voraussetzungen)
- [Installation](#installation)
  - [Manueller Download](#manueller-download)
  - [Installation des Managers](#installation-des-managers)
- [Aktualisierung](#aktualisierung)
- [Nutzung — Konsole (xvhost)](#nutzung--konsole-xvhost)
  - [Hilfe](#hilfe)
  - [Virtuellen Host erstellen](#virtuellen-host-erstellen)
  - [Host-Informationen anzeigen](#host-informationen-anzeigen)
  - [Alle Hosts auflisten](#alle-hosts-auflisten)
  - [Host löschen](#host-löschen)
  - [SSL-Zertifikat hinzufügen](#ssl-zertifikat-hinzufügen)
  - [SSL-Zertifikat entfernen](#ssl-zertifikat-entfernen)
  - [Document Root ändern](#document-root-ändern)
  - [Apache stoppen/starten/neustarten](#apache-stoppenstartenneustarten)
  - [Anwendungspfad registrieren](#anwendungspfad-registrieren)
  - [Berechtigungen der Windows-Hosts-Datei](#berechtigungen-der-windows-hosts-datei)
- [Web-Panel (grafische Oberfläche)](#web-panel-grafische-oberfläche)
  - [Voraussetzungen für das Web-Panel](#voraussetzungen-für-das-web-panel)
  - [Zugriff](#zugriff)
  - [Panel-Funktionen](#panel-funktionen)
- [SSL-Zertifikate](#ssl-zertifikate)
  - [Wie funktioniert es?](#wie-funktioniert-es)
  - [CA-Zertifikat unter Windows vertrauen](#ca-zertifikat-unter-windows-vertrauen)
  - [CA-Zertifikat unter Firefox vertrauen](#ca-zertifikat-unter-firefox-vertrauen)
- [Konfiguration](#konfiguration)
- [Problemlösung](#problemlösung)
  - [SSL wird nicht generiert](#ssl-wird-nicht-generiert)
  - [Browser zeigt Sicherheitswarnung](#browser-zeigt-sicherheitswarnung)
  - [Hostname kann nicht aufgelöst werden](#hostname-kann-nicht-aufgelöst-werden)
  - [Apache startet nicht](#apache-startet-nicht)
  - [Berechtigungsfehler beim Erstellen eines Hosts](#berechtigungsfehler-beim-erstellen-eines-hosts)
- [Lizenz](#lizenz)

---

## Beschreibung

Xampp vHosts Manager ist ein Werkzeug, das die Erstellung und Verwaltung virtueller Hosts in Xampp für Windows erheblich vereinfacht. Es ermöglicht:

- Erstellung virtueller Hosts in Sekundenschnelle
- Generierung selbstsignierter SSL-Zertifikate ohne komplexe OpenSSL-Befehle
- Verwaltung über die Konsole (`xvhost`) oder ein interaktives Web-Panel

Entwickelt für Entwickler, die mit Xampp arbeiten und mehrere lokale Domains mit SSL schnell und unkompliziert benötigen.

---

## Funktionen

- Virtuelle Hosts mit benutzerdefiniertem Namen erstellen
- Vorhandene virtuelle Hosts löschen
- Detaillierte Informationen zu einem Host anzeigen
- Alle virtuellen Hosts auflisten
- Selbstsignierte SSL-Zertifikate zu jedem Host hinzufügen
- SSL-Zertifikate von einem Host entfernen
- Document Root eines bestehenden Hosts ändern
- Apache starten, stoppen und neu starten
- **Modernes Web-Panel** mit dunkler grafischer Oberfläche
- Eigenes CA-Zertifikat, das als vertrauenswürdige Zertifizierungsstelle in Windows installiert werden kann

---

## Kompatibilität

- Kompatibel mit allen Xampp-Versionen, die PHP 5.4 oder höher verwenden
- **Nicht** kompatibel mit der portablen Version von Xampp
- Betriebssystem: Nur Windows

---

## Voraussetzungen

1. **Xampp installiert** (selbstverständlich)
2. **PHP** muss erreichbar sein — das Installationsprogramm fügt den PHP-Pfad von Xampp automatisch zur Windows-Umgebungsvariable PATH hinzu
3. **Optional:** Composer installiert (nur wenn du eine Installation über Composer wünschst)

---

## Installation

### Manueller Download (empfohlen)

1. Lade die [neueste Version](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest) herunter
2. Entpacke den Inhalt an einen gemeinsamen Speicherort, z. B. `C:\xampp\hosts` oder `D:\xvhm`
   > **Wichtig:** Lege das Verzeichnis nicht in `C:\Program Files` oder an andere Orte, die Administratorrechte zum Schreiben von Dateien erfordern
3. Öffne ein Terminal **als Administrator**
4. Navigiere zu dem Verzeichnis, in das du den Manager entpackt hast:
   ```cmd
   cd /D C:\xampp\hosts
   ```
5. Führe das Installationsprogramm aus:
   ```cmd
   xvhost install
   ```
6. Folge den Schritten auf dem Bildschirm (Xampp-Pfad, empfohlener DocumentRoot-Pfad usw.)
7. Schließe das Terminal (um temporäre Umgebungsvariablen zu bereinigen)
8. Öffne ein neues Terminal — von nun an kannst du `xvhost` von jedem beliebigen Ort aus verwenden

### Installation des Managers

Der Befehl `xvhost install` führt automatisch Folgendes aus:

- Registriert den Pfad des Managers in der Windows-Umgebungsvariable PATH
- Konfiguriert die Datei `settings.ini` mit den Pfaden deiner Xampp-Installation
- Generiert das CA-Zertifikat (Zertifizierungsstelle) im Verzeichnis `cacert/`
- Erteilt die notwendigen Berechtigungen für die Windows-`hosts`-Datei

---

## Aktualisierung

1. Sichere deine `settings.ini`-Datei und das Verzeichnis `cacert/`
2. Lösche den gesamten Inhalt des Manager-Verzeichnisses
3. Lade die [neueste Version](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest) herunter und entpacke sie in dasselbe Verzeichnis
4. Stelle deine `settings.ini`-Datei und das Verzeichnis `cacert/` wieder her

---

## Nutzung — Konsole (xvhost)

Nach der Installation kannst du `xvhost` von jedem Terminal aus ausführen, **ohne Administratorrechte** (außer bei Befehlen, die Systemkonfigurationen ändern).

### Hilfe

```
xvhost help
```

### Virtuellen Host erstellen

```
xvhost new [HOSTNAME]
```

Beispiel:
```
xvhost new meineapp.local
```

> Der Parameter `HOSTNAME` ist optional. Wenn du ihn nicht angibst, wirst du während des Vorgangs zur Eingabe aufgefordert.

Während der Erstellung wirst du gefragt nach:
- **Document Root** — Pfad, in dem sich die Dateien der Website befinden
- **E-Mail-Adresse des Administrators**
- **SSL hinzufügen?** — bei Bestätigung wird automatisch ein selbstsigniertes SSL-Zertifikat generiert

### Host-Informationen anzeigen

```
xvhost show [HOSTNAME]
```

Beispiel:
```
xvhost show meineapp.local
```

### Alle Hosts auflisten

```
xvhost list
```

### Host löschen

```
xvhost remove [HOSTNAME]
```

Beispiel:
```
xvhost remove meineapp.local
```

Dies löscht die Apache-Konfiguration, das SSL-Zertifikat (falls vorhanden) und den Eintrag in der Windows-`hosts`-Datei.

### SSL-Zertifikat hinzufügen

```
xvhost add_ssl [HOSTNAME]
```

Beispiel:
```
xvhost add_ssl meineapp.local
```

### SSL-Zertifikat entfernen

```
xvhost remove_ssl [HOSTNAME]
```

### Document Root ändern

```
xvhost change_docroot [HOSTNAME]
```

### Apache stoppen/starten/neustarten

```
xvhost stop_apache
xvhost start_apache
xvhost restart_apache
```

### Anwendungspfad registrieren

Wenn du den Manager in einen anderen Ordner verschiebst, kannst du den neuen Pfad wie folgt registrieren:

```
xvhost register_path
```

> Erfordert Administratorrechte.

### Berechtigungen der Windows-Hosts-Datei

Damit der Manager automatisch Einträge zur Windows-`hosts`-Datei hinzufügen kann:

```
xvhost grantperms_winhosts
```

> Erfordert Administratorrechte. Dieser Befehl muss nur einmal ausgeführt werden.

---

## Web-Panel (grafische Oberfläche)

Zusätzlich zur Konsole enthält das Projekt ein **modernes Web-Panel**, das über den Browser zugänglich ist.

### Voraussetzungen für das Web-Panel

- Apache mit laufendem PHP (selbstverständlich)
- Das Manager-Verzeichnis muss sich im Apache-Dokumentenstammbaum befinden oder es muss ein virtueller Host darauf verweisen

### Zugriff

Wenn du den Manager in `C:\xampp\hosts` installiert hast, kannst du wie folgt vorgehen:

**Option A — Virtueller Host:** Erstelle einen virtuellen Host, der auf das Verzeichnis zeigt:
```
xvhost new xvhm.local
```
Gib bei der Abfrage des Document Roots `C:\xampp\hosts` ein und besuche anschließend `http://xvhm.local`

**Option B — Direkt mit PHP:** Öffne ein Terminal und führe folgenden Befehl aus:
```
C:\xampp\php\php.exe -S localhost:8080 -t C:\xampp\hosts
```
Besuche anschließend `http://localhost:8080`

### Panel-Funktionen

Das Web-Panel ermöglicht:

- **Alle virtuellen Hosts anzeigen** inklusive SSL-Status
- **Neue Hosts erstellen** mit einem Formular (Name, Document Root, E-Mail, SSL)
- **Hosts im Browser öffnen** per Klick
- **Hosts direkt löschen**
- **Apache steuern** (starten, stoppen, neu starten)
- **Apache-Status** in Echtzeit anzeigen
- Dunkles Design (Dark Mode)

---

## SSL-Zertifikate

### Wie funktioniert es?

Der Manager verwaltet zwei Arten von Zertifikaten:

1. **CA-Root-Zertifikat** (`cacert/cacert.crt`) — Wird einmalig während der Installation generiert. Es ist die Zertifizierungsstelle (CA), die alle Zertifikate der virtuellen Hosts signiert.

2. **Host-Zertifikate** — Jeder Host, der SSL aktiviert, erhält sein eigenes, von der CA signiertes Zertifikat. Die Zertifikate enthalten Subject Alternative Names (SANs) für den Hostnamen und `www.*`.

**Speicherorte:**
- CA-Zertifikate: `C:\xampp\hosts\cacert\`
- Host-Zertifikate: `C:\xampp\apache\conf\extra\certs\`
- Private Schlüssel: `C:\xampp\apache\conf\extra\keys\`
- Apache-SSL-Konfigurationen: `C:\xampp\apache\conf\extra\vhosts_ssl\`

### CA-Zertifikat unter Windows vertrauen

Damit der Browser **keine Sicherheitswarnungen** anzeigt, wenn du `https://deineseite.local` aufrufst:

1. Öffne ein Terminal **als Administrator**
2. Führe folgenden Befehl aus:
   ```cmd
   certutil -addstore -f Root C:\xampp\hosts\cacert\cacert.crt
   ```
   (Passe den Pfad an, falls du den Manager in einem anderen Verzeichnis installiert hast)
3. Starte den Browser neu

Bei Verwendung von **Chrome oder Edge** kannst du auch:
- `chrome://settings/security` aufrufen → Zertifikate verwalten → Importieren
- `C:\xampp\hosts\cacert\cacert.crt` auswählen
- "Vertrauenswürdige Stammzertifizierungsstellen" wählen
- Fertigstellen

### CA-Zertifikat unter Firefox vertrauen

Firefox verwendet einen eigenen, von Windows unabhängigen Zertifikatsspeicher:

1. Öffne Firefox
2. Gehe zu **Einstellungen** → **Datenschutz & Sicherheit** → **Zertifikate**
3. Klicke auf **Zertifikate anzeigen** → Registerkarte **Autoritäten**
4. Klicke auf **Importieren**
5. Wähle `C:\xampp\hosts\cacert\cacert.crt`
6. Aktiviere **"Dieser Zertifizierungsstelle vertrauen, um Websites zu identifizieren"**
7. Bestätigen

---

## Konfiguration

Die gesamte Konfiguration befindet sich in der Datei `settings.ini` im Manager-Verzeichnis:

```ini
[DirectoryPaths]
; Pfad zu deiner Xampp-Installation
Xampp = "C:\xampp"

[Suggestions]
; Vorgeschlagener Pfad als DocumentRoot beim Erstellen eines neuen Hosts
; {{host_name}} wird durch den Hostnamen ersetzt
DocumentRoot = "C:\xampp\hosts\{{host_name}}"

; Vorgeschlagene E-Mail-Adresse für ServerAdmin
AdminEmail = "admin@localhost"

[ListViewMode]
; Anzahl der pro Seite angezeigten Einträge bei der Host-Liste
RecordPerPage = "5"
```

---

## Problemlösung

### SSL wird nicht generiert

**Symptom:** Beim Ausführen von `xvhost add_ssl meineapp.local` schlägt der Vorgang fehl, ohne das Zertifikat zu erstellen.

**Ursache:** In früheren Versionen wurde die Seriennummer des Zertifikats mit `php -r "echo md5(...)"` generiert, aber `php` war nicht im System-PATH. Die aktuelle Version behebt dies durch Verwendung von `openssl rand -hex 16`.

**Lösung:** Stelle sicher, dass du die neueste Version des Managers verwendest. Falls das Problem weiterhin besteht, überprüfe, ob `C:\xampp\apache\bin\openssl.exe` vorhanden ist.

### Browser zeigt Sicherheitswarnung

**Symptom:** Beim Öffnen von `https://meineapp.local` erscheint "Ihre Verbindung ist nicht sicher" (NET::ERR_CERT_AUTHORITY_INVALID).

**Ursache:** Das SSL-Zertifikat wurde von der lokalen CA signiert, aber Windows/Firefox vertraut dieser nicht.

**Lösung:** Installiere das CA-Zertifikat als vertrauenswürdige Zertifizierungsstelle (siehe Abschnitt [CA-Zertifikat unter Windows vertrauen](#ca-zertifikat-unter-windows-vertrauen)).

### Hostname kann nicht aufgelöst werden

**Symptom:** `http://meineapp.local` lädt nicht, "Server nicht gefunden".

**Ursache:** Der Host ist nicht in der Windows-`hosts`-Datei eingetragen.

**Lösung:** Stelle sicher, dass du `xvhost grantperms_winhosts` als Administrator ausgeführt hast (nur einmal erforderlich). Erstelle dann den Host mit `xvhost new meineapp.local` oder füge manuell folgende Einträge hinzu:
```
127.0.0.1   meineapp.local
127.0.0.1   www.meineapp.local
```
in `C:\Windows\System32\drivers\etc\hosts`

### Apache startet nicht

**Symptom:** Apache startet nach der Installation oder Änderung eines Hosts nicht.

**Mögliche Ursachen und Lösungen:**
- **Port bereits belegt:** Ein anderes Programm (Skype, IIS, Docker) verwendet bereits Port 80 oder 443. Stoppe dieses Programm oder ändere die Ports in `C:\xampp\apache\conf\httpd.conf`
- **Syntaxfehler:** Überprüfe mit folgendem Befehl:
  ```cmd
  C:\xampp\apache\bin\httpd.exe -t
  ```
- **OpenSSL fehlt:** Stelle sicher, dass `C:\xampp\apache\bin\openssl.exe` existiert
- **SSL-Konflikte:** Wenn beschädigte SSL-Konfigurationen vorliegen, überprüfe die Dateien in `C:\xampp\apache\conf\extra\vhosts_ssl\`

### Berechtigungsfehler beim Erstellen eines Hosts

**Symptom:** "Permission denied" beim Erstellen eines Hosts oder beim Schreiben in die `hosts`-Datei.

**Lösung:** Führe einmalig folgenden Befehl aus:
```
xvhost grantperms_winhosts
```
als Administrator. Danach sind keine erhöhten Rechte mehr zum Erstellen von Hosts erforderlich.

---

## Lizenz

[MIT](LICENSE) © Jose Alexis Correa Valencia
