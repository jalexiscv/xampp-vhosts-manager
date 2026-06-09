# Xampp vHosts Manager

Système de gestion d'hôtes virtuels et de certificats SSL auto-signés pour Xampp sous Windows.

**Auteur :** Jose Alexis Correa Valencia — [jalexiscv@gmail.com](mailto:jalexiscv@gmail.com)
**Licence :** [MIT](LICENSE)
**Changelog :** [changelog/changelog.md](../../changelog/changelog.md)
**Documentation :** [docs/es/](../es/readme.md) • [docs/en/](../en/readme.md) • [docs/fr/](readme.md)

![Xampp vHosts Manager](https://user-images.githubusercontent.com/9862115/70820328-f78de800-1e0a-11ea-894a-b7021942c158.jpg)

---

## Table des matières

- [Description](#description)
- [Fonctionnalités](#fonctionnalités)
- [Compatibilité](#compatibilité)
- [Prérequis](#prérequis)
- [Installation](#installation)
  - [Téléchargement manuel](#téléchargement-manuel)
  - [Installation du gestionnaire](#installation-du-gestionnaire)
- [Mise à jour](#mise-à-jour)
- [Utilisation — Console (xvhost)](#utilisation--console-xvhost)
  - [Aide](#aide)
  - [Créer un hôte virtuel](#créer-un-hôte-virtuel)
  - [Afficher les informations d'un hôte](#afficher-les-informations-dun-hôte)
  - [Lister tous les hôtes](#lister-tous-les-hôtes)
  - [Supprimer un hôte](#supprimer-un-hôte)
  - [Ajouter un certificat SSL](#ajouter-un-certificat-ssl)
  - [Supprimer un certificat SSL](#supprimer-un-certificat-ssl)
  - [Changer le Document Root](#changer-le-document-root)
  - [Arrêter/Démarrer/Redémarrer Apache](#arrêterdémarrerredémarrer-apache)
  - [Enregistrer le chemin de l'application](#enregistrer-le-chemin-de-lapplication)
  - [Permissions du fichier hosts de Windows](#permissions-du-fichier-hosts-de-windows)
- [Panneau Web (interface graphique)](#panneau-web-interface-graphique)
  - [Prérequis du panneau web](#prérequis-du-panneau-web)
  - [Comment y accéder](#comment-y-accéder)
  - [Fonctions du panneau](#fonctions-du-panneau)
- [Certificats SSL](#certificats-ssl)
  - [Comment ça fonctionne ?](#comment-ça-fonctionne)
  - [Approuver le certificat CA sous Windows](#approuver-le-certificat-ca-sous-windows)
  - [Approuver le certificat CA dans Firefox](#approuver-le-certificat-ca-dans-firefox)
- [Configuration](#configuration)
- [Résolution de problèmes](#résolution-de-problèmes)
  - [Le SSL ne se génère pas](#le-ssl-ne-se-génère-pas)
  - [Le navigateur affiche un avertissement de sécurité](#le-navigateur-affiche-un-avertissement-de-sécurité)
  - [Impossible de résoudre le nom d'hôte](#impossible-de-résoudre-le-nom-dhôte)
  - [Apache ne démarre pas](#apache-ne-démarre-pas)
  - [Erreur de permissions lors de la création d'un hôte](#erreur-de-permissions-lors-de-la-création-dun-hôte)
- [Licence](#licence)

---

## Description

Xampp vHosts Manager est un outil qui facilite la création et la gestion d'hôtes virtuels dans Xampp pour Windows. Il permet de :

- Créer des hôtes virtuels en quelques secondes
- Générer des certificats SSL auto-signés sans utiliser de commandes OpenSSL complexes
- Administrer le tout depuis la console (`xvhost`) ou depuis un panneau web interactif

Il est conçu pour les développeurs qui travaillent avec Xampp et ont besoin de plusieurs domaines locaux avec SSL de manière rapide et simple.

---

## Fonctionnalités

- Créer des hôtes virtuels avec un nom personnalisé
- Supprimer des hôtes virtuels existants
- Afficher les informations détaillées d'un hôte
- Lister tous les hôtes virtuels
- Ajouter des certificats SSL auto-signés à n'importe quel hôte
- Supprimer les certificats SSL d'un hôte
- Modifier le Document Root d'un hôte existant
- Démarrer, arrêter et redémarrer Apache
- **Panneau web** moderne avec interface graphique sombre
- Certificat CA personnel pouvant être installé comme entité de confiance sous Windows

---

## Compatibilité

- Compatible avec toutes les versions de Xampp utilisant PHP 5.4 ou supérieur
- **Ne** supporte **pas** la version portable de Xampp
- Système d'exploitation : Windows uniquement

---

## Prérequis

1. **Xampp installé** (évidemment)
2. **PHP accessible** — l'installateur ajoute automatiquement le chemin PHP de Xampp au PATH de Windows
3. **Optionnel :** Composer installé (uniquement si vous souhaitez installer via Composer)

---

## Installation

### Téléchargement manuel (recommandé)

1. Téléchargez la [dernière version](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest)
2. Extrayez le contenu dans un emplacement partagé, par exemple `C:\xampp\hosts` ou `D:\xvhm`
   > **Important :** Ne le placez pas dans `C:\Program Files` ni dans des emplacements nécessitant des droits d'Administrateur pour écrire des fichiers
3. Ouvrez un terminal **en tant qu'Administrateur**
4. Naviguez jusqu'au répertoire où vous avez extrait le gestionnaire :
   ```cmd
   cd /D C:\xampp\hosts
   ```
5. Exécutez l'installateur :
   ```cmd
   xvhost install
   ```
6. Suivez les instructions à l'écran (chemin de Xampp, chemin du DocumentRoot suggéré, etc.)
7. Fermez le terminal (pour nettoyer les variables d'environnement temporaires)
8. Ouvrez un nouveau terminal — vous pouvez désormais utiliser `xvhost` depuis n'importe quel emplacement

### Installation du gestionnaire

La commande `xvhost install` effectue automatiquement :

- Enregistre le chemin du gestionnaire dans les variables d'environnement PATH de Windows
- Configure le fichier `settings.ini` avec les chemins de votre Xampp
- Génère le certificat d'Autorité de Certification (CA) dans `cacert/`
- Accorde les permissions nécessaires sur le fichier `hosts` de Windows

---

## Mise à jour

1. Sauvegardez votre fichier `settings.ini` et le dossier `cacert/`
2. Supprimez tout le contenu du répertoire du gestionnaire
3. Téléchargez la [dernière version](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest) et extrayez-la dans le même répertoire
4. Restaurez votre fichier `settings.ini` et le dossier `cacert/`

---

## Utilisation — Console (xvhost)

Une fois installé, vous pouvez exécuter `xvhost` depuis n'importe quel terminal **sans avoir besoin d'être Administrateur** (sauf pour les commandes qui modifient la configuration système).

### Aide

```
xvhost help
```

### Créer un hôte virtuel

```
xvhost new [NOM_HOTE]
```

Exemple :
```
xvhost new monsite.local
```

> Le paramètre `NOM_HOTE` est optionnel. Si vous ne le fournissez pas, il vous sera demandé de le saisir pendant le processus.

Pendant la création, il vous sera demandé :
- **Document Root** — chemin où se trouveront les fichiers du site
- **Email de l'administrateur**
- **Ajouter SSL ?** — si vous répondez oui, un certificat SSL auto-signé sera généré automatiquement

### Afficher les informations d'un hôte

```
xvhost show [NOM_HOTE]
```

Exemple :
```
xvhost show monsite.local
```

### Lister tous les hôtes

```
xvhost list
```

### Supprimer un hôte

```
xvhost remove [NOM_HOTE]
```

Exemple :
```
xvhost remove monsite.local
```

Cela supprime la configuration Apache, le SSL (s'il existe) et l'entrée du fichier `hosts` de Windows.

### Ajouter un certificat SSL

```
xvhost add_ssl [NOM_HOTE]
```

Exemple :
```
xvhost add_ssl monsite.local
```

### Supprimer un certificat SSL

```
xvhost remove_ssl [NOM_HOTE]
```

### Changer le Document Root

```
xvhost change_docroot [NOM_HOTE]
```

### Arrêter/Démarrer/Redémarrer Apache

```
xvhost stop_apache
xvhost start_apache
xvhost restart_apache
```

### Enregistrer le chemin de l'application

Si vous déplacez le gestionnaire vers un autre dossier, vous pouvez enregistrer le nouveau chemin avec :

```
xvhost register_path
```

> Nécessite les droits d'Administrateur.

### Permissions du fichier hosts de Windows

Pour que le gestionnaire puisse ajouter automatiquement des entrées au fichier `hosts` de Windows :

```
xvhost grantperms_winhosts
```

> Nécessite les droits d'Administrateur. Exécutez-le une seule fois.

---

## Panneau Web (interface graphique)

En plus de la console, le projet inclut un **panneau web moderne** accessible depuis le navigateur.

### Prérequis du panneau web

- Apache avec PHP en cours d'exécution (évidemment)
- Le répertoire du gestionnaire doit se trouver dans l'arborescence des documents d'Apache, ou avoir un hôte virtuel pointant vers lui

### Comment y accéder

Si vous avez installé le gestionnaire dans `C:\xampp\hosts`, vous pouvez :

**Option A — Hôte virtuel :** Créez un hôte virtuel pointant vers le répertoire :
```
xvhost new xvhm.local
```
Quand il demande le Document Root, saisissez `C:\xampp\hosts` et visitez `http://xvhm.local`

**Option B — Directement avec PHP :** Ouvrez un terminal et exécutez :
```
C:\xampp\php\php.exe -S localhost:8080 -t C:\xampp\hosts
```
Puis visitez `http://localhost:8080`

### Fonctions du panneau

Le panneau web permet de :

- **Voir tous les hôtes virtuels** avec leur état SSL
- **Créer de nouveaux hôtes** avec un formulaire (nom, Document Root, email, SSL)
- **Ouvrir les hôtes** dans le navigateur en un clic
- **Supprimer des hôtes** directement
- **Contrôler Apache** (démarrer, arrêter, redémarrer)
- **Voir l'état** d'Apache en temps réel
- Interface au design sombre (dark mode)

---

## Certificats SSL

### Comment ça fonctionne ?

Le gestionnaire gère deux types de certificats :

1. **Certificat CA racine** (`cacert/cacert.crt`) — Généré une seule fois lors de l'installation. C'est l'Autorité de Certification qui signe tous les certificats des hôtes virtuels.

2. **Certificats d'hôtes** — Chaque hôte activant SSL reçoit son propre certificat signé par la CA racine. Les certificats incluent des Subject Alternative Names (SANs) pour le nom d'hôte et `www.*`.

**Emplacements :**
- Certificats CA : `C:\xampp\hosts\cacert\`
- Certificats d'hôtes : `C:\xampp\apache\conf\extra\certs\`
- Clés privées : `C:\xampp\apache\conf\extra\keys\`
- Configurations SSL Apache : `C:\xampp\apache\conf\extra\vhosts_ssl\`

### Approuver le certificat CA sous Windows

Pour que le navigateur **n'affiche pas d'avertissements de sécurité** lors de l'accès à `https://votresite.local` :

1. Ouvrez un terminal **en tant qu'Administrateur**
2. Exécutez :
   ```cmd
   certutil -addstore -f Root C:\xampp\hosts\cacert\cacert.crt
   ```
   (ajustez le chemin si vous avez installé le gestionnaire dans un autre répertoire)
3. Redémarrez le navigateur

Si vous utilisez **Chrome ou Edge**, vous pouvez aussi :
- Aller dans `chrome://settings/security` → Gérer les certificats → Importer
- Sélectionner `C:\xampp\hosts\cacert\cacert.crt`
- Choisir « Autorités de certification racines de confiance »
- Finaliser

### Approuver le certificat CA dans Firefox

Firefox utilise son propre magasin de certificats, indépendant de celui de Windows :

1. Ouvrez Firefox
2. Allez dans **Paramètres** → **Vie privée et sécurité** → **Certificats**
3. Cliquez sur **Voir les certificats** → onglet **Autorités**
4. Cliquez sur **Importer**
5. Sélectionnez `C:\xampp\hosts\cacert\cacert.crt`
6. Cochez **« Faire confiance à cette autorité de certification pour identifier les sites web »**
7. Accepter

---

## Configuration

Toute la configuration se trouve dans le fichier `settings.ini` dans le répertoire du gestionnaire :

```ini
[DirectoryPaths]
; Chemin de votre installation Xampp
Xampp = "C:\xampp"

[Suggestions]
; Chemin suggéré comme DocumentRoot lors de la création d'un nouvel hôte
; {{host_name}} est remplacé par le nom de l'hôte
DocumentRoot = "C:\xampp\hosts\{{host_name}}"

; Email suggéré comme ServerAdmin
AdminEmail = "admin@localhost"

[ListViewMode]
; Nombre d'enregistrements affichés par page lors du listage des hôtes
RecordPerPage = "5"
```

---

## Résolution de problèmes

### Le SSL ne se génère pas

**Symptôme :** Lors de l'exécution de `xvhost add_ssl monsite.local`, le processus échoue sans créer le certificat.

**Cause :** Dans les versions antérieures, le numéro de série du certificat était généré avec `php -r "echo md5(...)"` mais `php` n'était pas dans le PATH du système. La version actuelle corrige cela en utilisant `openssl rand -hex 16`.

**Solution :** Assurez-vous d'avoir la version la plus récente du gestionnaire. Si le problème persiste, vérifiez que `C:\xampp\apache\bin\openssl.exe` existe.

### Le navigateur affiche un avertissement de sécurité

**Symptôme :** En ouvrant `https://monsite.local`, le message « Votre connexion n'est pas privée » apparaît (NET::ERR_CERT_AUTHORITY_INVALID).

**Cause :** Le certificat SSL est signé par la CA locale, mais Windows/Firefox ne lui fait pas confiance.

**Solution :** Installez le certificat CA comme entité de confiance (voir la section [Approuver le certificat CA sous Windows](#approuver-le-certificat-ca-sous-windows)).

### Impossible de résoudre le nom d'hôte

**Symptôme :** `http://monsite.local` ne se charge pas, « Serveur introuvable ».

**Cause :** L'hôte n'est pas dans le fichier `hosts` de Windows.

**Solution :** Assurez-vous d'avoir exécuté `xvhost grantperms_winhosts` en tant qu'Administrateur (une seule fois). Ensuite, créez l'hôte avec `xvhost new monsite.local` ou ajoutez manuellement :
```
127.0.0.1   monsite.local
127.0.0.1   www.monsite.local
```
dans `C:\Windows\System32\drivers\etc\hosts`

### Apache ne démarre pas

**Symptôme :** Apache ne démarre pas après l'installation ou la modification d'un hôte.

**Causes possibles et solutions :**
- **Port utilisé :** Un autre programme (Skype, IIS, Docker) utilise le port 80 ou 443. Arrêtez ce programme ou modifiez les ports dans `C:\xampp\apache\conf\httpd.conf`
- **Erreur de syntaxe :** Vérifiez avec :
  ```cmd
  C:\xampp\apache\bin\httpd.exe -t
  ```
- **OpenSSL manquant :** Assurez-vous que `C:\xampp\apache\bin\openssl.exe` existe
- **Conflits SSL :** Si des configurations SSL sont corrompues, vérifiez les fichiers dans `C:\xampp\apache\conf\extra\vhosts_ssl\`

### Erreur de permissions lors de la création d'un hôte

**Symptôme :** « Permission denied » lors de la création d'un hôte ou de l'écriture dans le fichier `hosts`.

**Solution :** Exécutez une fois :
```
xvhost grantperms_winhosts
```
en tant qu'Administrateur. Ensuite, vous n'aurez plus besoin de privilèges élevés pour créer des hôtes.

---

## Licence

[MIT](LICENSE) © Jose Alexis Correa Valencia
