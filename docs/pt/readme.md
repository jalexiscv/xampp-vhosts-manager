# Xampp vHosts Manager

Sistema de gerenciamento de hosts virtuais e certificados SSL autoassinados para Xampp no Windows.

**Autor:** Jose Alexis Correa Valencia — [jalexiscv@gmail.com](mailto:jalexiscv@gmail.com)
**Licença:** [MIT](LICENSE)
**Changelog:** [changelog/changelog.md](changelog/changelog.md)
**Documentação:** [docs/es/](docs/es/readme.md) • [docs/en/](docs/en/readme.md)

![Xampp vHosts Manager](https://user-images.githubusercontent.com/9862115/70820328-f78de800-1e0a-11ea-894a-b7021942c158.jpg)

---

## Índice

- [Descrição](#descrição)
- [Funcionalidades](#funcionalidades)
- [Compatibilidade](#compatibilidade)
- [Requisitos](#requisitos)
- [Instalação](#instalação)
  - [Download manual](#download-manual)
  - [Instalação do gerenciador](#instalação-do-gerenciador)
- [Atualização](#atualização)
- [Uso — Console (xvhost)](#uso--console-xvhost)
  - [Ajuda](#ajuda)
  - [Criar um host virtual](#criar-um-host-virtual)
  - [Ver informações de um host](#ver-informações-de-um-host)
  - [Listar todos os hosts](#listar-todos-os-hosts)
  - [Excluir um host](#excluir-um-host)
  - [Adicionar certificado SSL](#adicionar-certificado-ssl)
  - [Remover certificado SSL](#remover-certificado-ssl)
  - [Alterar Document Root](#alterar-document-root)
  - [Parar/Iniciar/Reiniciar Apache](#parariniciarreiniciar-apache)
  - [Registrar caminho da aplicação](#registrar-caminho-da-aplicação)
  - [Permissões do arquivo hosts do Windows](#permissões-do-arquivo-hosts-do-windows)
- [Painel Web (interface gráfica)](#painel-web-interface-gráfica)
  - [Requisitos do painel web](#requisitos-do-painel-web)
  - [Como acessar](#como-acessar)
  - [Funções do painel](#funções-do-painel)
- [Certificados SSL](#certificados-ssl)
  - [Como funciona?](#como-funciona)
  - [Confiar o certificado CA no Windows](#confiar-o-certificado-ca-no-windows)
  - [Confiar o certificado CA no Firefox](#confiar-o-certificado-ca-no-firefox)
- [Configuração](#configuração)
- [Solução de problemas](#solução-de-problemas)
  - [O SSL não é gerado](#o-ssl-não-é-gerado)
  - [O navegador exibe aviso de segurança](#o-navegador-exibe-aviso-de-segurança)
  - [Não é possível resolver o nome do host](#não-é-possível-resolver-o-nome-do-host)
  - [Apache não inicia](#apache-não-inicia)
  - [Erro de permissão ao criar host](#erro-de-permissão-ao-criar-host)
- [Licença](#licença)

---

## Descrição

Xampp vHosts Manager é uma ferramenta que facilita a criação e o gerenciamento de hosts virtuais no Xampp para Windows. Permite:

- Criar hosts virtuais em segundos
- Gerar certificados SSL autoassinados sem usar comandos complexos do OpenSSL
- Gerenciar tudo pelo console (`xvhost`) ou por um painel web interativo

Foi projetado para desenvolvedores que trabalham com Xampp e precisam de múltiplos domínios locais com SSL de forma rápida e simples.

---

## Funcionalidades

- Criar hosts virtuais com nome personalizado
- Excluir hosts virtuais existentes
- Exibir informações detalhadas de um host
- Listar todos os hosts virtuais
- Adicionar certificados SSL autoassinados a qualquer host
- Remover certificados SSL de um host
- Alterar o Document Root de um host existente
- Iniciar, parar e reiniciar o Apache
- **Painel web** moderno com interface gráfica escura
- Certificado CA próprio que pode ser instalado como entidade de confiança no Windows

---

## Compatibilidade

- Compatível com todas as versões do Xampp que utilizam PHP 5.4 ou superior
- **Não** suporta a versão portátil do Xampp
- Sistema operacional: Windows apenas

---

## Requisitos

1. **Xampp instalado** (obviamente)
2. **PHP** acessível — o instalador adiciona o caminho do PHP do Xampp automaticamente ao PATH do Windows
3. **Opcional:** Composer instalado (apenas se desejar instalar via Composer)

---

## Instalação

### Download manual (recomendado)

1. Baixe a [última versão](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest)
2. Extraia o conteúdo em um local compartilhado, por exemplo `C:\xampp\hosts` ou `D:\xvhm`
   > **Importante:** Não coloque em `C:\Program Files` nem em locais que exijam permissões de Administrador para gravar arquivos
3. Abra um terminal **como Administrador**
4. Navegue até o diretório onde extraiu o gerenciador:
   ```cmd
   cd /D C:\xampp\hosts
   ```
5. Execute o instalador:
   ```cmd
   xvhost install
   ```
6. Siga as etapas na tela (caminho do Xampp, caminho do DocumentRoot sugerido, etc.)
7. Saia do terminal (para limpar variáveis de ambiente temporárias)
8. Abra um novo terminal — agora você pode usar `xvhost` de qualquer local

### Instalação do gerenciador

O comando `xvhost install` realiza automaticamente:

- Registra o caminho do gerenciador nas variáveis de ambiente PATH do Windows
- Configura o arquivo `settings.ini` com os caminhos do seu Xampp
- Gera o certificado de Autoridade Certificadora (CA) em `cacert/`
- Concede as permissões necessárias sobre o arquivo `hosts` do Windows

---

## Atualização

1. Faça backup do arquivo `settings.ini` e da pasta `cacert/`
2. Exclua todo o conteúdo do diretório do gerenciador
3. Baixe a [última versão](https://github.com/jalexiscv/xampp-vhosts-manager/releases/latest) e extraia no mesmo diretório
4. Restaure o arquivo `settings.ini` e a pasta `cacert/`

---

## Uso — Console (xvhost)

Após a instalação, você pode executar `xvhost` de qualquer terminal **sem precisar ser Administrador** (exceto comandos que modificam configurações do sistema).

### Ajuda

```
xvhost help
```

### Criar um host virtual

```
xvhost new [NOME_HOST]
```

Exemplo:
```
xvhost new meusite.local
```

> O parâmetro `NOME_HOST` é opcional. Se não for informado, será solicitado durante o processo.

Durante a criação, será perguntado:
- **Document Root** — caminho onde estarão os arquivos do site
- **Email do administrador**
- **Adicionar SSL?** — se responder sim, um certificado SSL autoassinado será gerado automaticamente

### Ver informações de um host

```
xvhost show [NOME_HOST]
```

Exemplo:
```
xvhost show meusite.local
```

### Listar todos os hosts

```
xvhost list
```

### Excluir um host

```
xvhost remove [NOME_HOST]
```

Exemplo:
```
xvhost remove meusite.local
```

Isso remove a configuração do Apache, o SSL (se existir) e a entrada do arquivo `hosts` do Windows.

### Adicionar certificado SSL

```
xvhost add_ssl [NOME_HOST]
```

Exemplo:
```
xvhost add_ssl meusite.local
```

### Remover certificado SSL

```
xvhost remove_ssl [NOME_HOST]
```

### Alterar Document Root

```
xvhost change_docroot [NOME_HOST]
```

### Parar/Iniciar/Reiniciar Apache

```
xvhost stop_apache
xvhost start_apache
xvhost restart_apache
```

### Registrar caminho da aplicação

Se você mover o gerenciador para outra pasta, pode registrar o novo caminho com:

```
xvhost register_path
```

> Requer permissões de Administrador.

### Permissões do arquivo hosts do Windows

Para que o gerenciador possa adicionar entradas ao arquivo `hosts` do Windows automaticamente:

```
xvhost grantperms_winhosts
```

> Requer permissões de Administrador. Só precisa ser executado uma vez.

---

## Painel Web (interface gráfica)

Além do console, o projeto inclui um **painel web moderno** acessível pelo navegador.

### Requisitos do painel web

- Apache com PHP em execução (obviamente)
- O diretório do gerenciador deve estar dentro da árvore de documentos do Apache, ou ter um host virtual apontando para ele

### Como acessar

Se você instalou o gerenciador em `C:\xampp\hosts`, pode:

**Opção A — Host virtual:** Crie um host virtual que aponte para o diretório:
```
xvhost new xvhm.local
```
Quando solicitar o Document Root, informe `C:\xampp\hosts` e visite `http://xvhm.local`

**Opção B — Diretamente com PHP:** Abra um terminal e execute:
```
C:\xampp\php\php.exe -S localhost:8080 -t C:\xampp\hosts
```
Depois visite `http://localhost:8080`

### Funções do painel

O painel web permite:

- **Ver todos os hosts virtuais** com seu status SSL
- **Criar novos hosts** com formulário (nome, Document Root, email, SSL)
- **Abrir hosts** no navegador com um clique
- **Excluir hosts** diretamente
- **Controlar o Apache** (iniciar, parar, reiniciar)
- **Ver o status** do Apache em tempo real
- Interface com design escuro (modo noturno)

---

## Certificados SSL

### Como funciona?

O gerenciador lida com dois tipos de certificados:

1. **Certificado CA raiz** (`cacert/cacert.crt`) — Gerado uma única vez durante a instalação. É a Autoridade Certificadora que assina todos os certificados dos hosts virtuais.

2. **Certificados de hosts** — Cada host que habilita SSL recebe seu próprio certificado assinado pela CA raiz. Os certificados incluem Subject Alternative Names (SANs) para o nome do host e `www.*`.

**Locais:**
- Certificados CA: `C:\xampp\hosts\cacert\`
- Certificados de hosts: `C:\xampp\apache\conf\extra\certs\`
- Chaves privadas: `C:\xampp\apache\conf\extra\keys\`
- Configurações SSL do Apache: `C:\xampp\apache\conf\extra\vhosts_ssl\`

### Confiar o certificado CA no Windows

Para que o navegador **não exiba avisos de segurança** ao acessar `https://seudominio.local`:

1. Abra um terminal **como Administrador**
2. Execute:
   ```cmd
   certutil -addstore -f Root C:\xampp\hosts\cacert\cacert.crt
   ```
   (ajuste o caminho se instalou o gerenciador em outro diretório)
3. Reinicie o navegador

Se usar **Chrome ou Edge**, também pode:
- Ir em `chrome://settings/security` → Gerenciar certificados → Importar
- Selecionar `C:\xampp\hosts\cacert\cacert.crt`
- Escolher "Entidades de certificação raiz confiáveis"
- Finalizar

### Confiar o certificado CA no Firefox

O Firefox usa seu próprio armazenamento de certificados, independente do Windows:

1. Abra o Firefox
2. Vá em **Configurações** → **Privacidade e Segurança** → **Certificados**
3. Clique em **Ver certificados** → aba **Autoridades**
4. Clique em **Importar**
5. Selecione `C:\xampp\hosts\cacert\cacert.crt`
6. Marque **"Confiar nesta autoridade certificadora para identificar sites"**
7. Confirmar

---

## Configuração

Toda a configuração está no arquivo `settings.ini` dentro do diretório do gerenciador:

```ini
[DirectoryPaths]
; Caminho da sua instalação do Xampp
Xampp = "C:\xampp"

[Suggestions]
; Caminho sugerido como DocumentRoot ao criar um novo host
; {{host_name}} é substituído pelo nome do host
DocumentRoot = "C:\xampp\hosts\{{host_name}}"

; Email sugerido como ServerAdmin
AdminEmail = "admin@localhost"

[ListViewMode]
; Número de registros exibidos por página ao listar hosts
RecordPerPage = "5"
```

---

## Solução de problemas

### O SSL não é gerado

**Sintoma:** Ao executar `xvhost add_ssl meusite.local`, o processo falha sem criar o certificado.

**Causa:** Em versões anteriores, o número de série do certificado era gerado com `php -r "echo md5(...)"` mas o `php` não estava no PATH do sistema. A versão atual corrige isso usando `openssl rand -hex 16`.

**Solução:** Certifique-se de ter a versão mais recente do gerenciador. Se o problema persistir, verifique se `C:\xampp\apache\bin\openssl.exe` existe.

### O navegador exibe aviso de segurança

**Sintoma:** Ao abrir `https://meusite.local` aparece "Sua conexão não é privada" (NET::ERR_CERT_AUTHORITY_INVALID).

**Causa:** O certificado SSL é assinado pela CA local, mas o Windows/Firefox não confia nela.

**Solução:** Instale o certificado CA como entidade de confiança (veja a seção [Confiar o certificado CA no Windows](#confiar-o-certificado-ca-no-windows)).

### Não é possível resolver o nome do host

**Sintoma:** `http://meusite.local` não carrega, "Servidor não encontrado".

**Causa:** O host não está no arquivo `hosts` do Windows.

**Solução:** Certifique-se de ter executado `xvhost grantperms_winhosts` como Administrador (apenas uma vez). Depois crie o host com `xvhost new meusite.local` ou adicione manualmente:
```
127.0.0.1   meusite.local
127.0.0.1   www.meusite.local
```
em `C:\Windows\System32\drivers\etc\hosts`

### Apache não inicia

**Sintoma:** O Apache não inicia após instalar ou modificar um host.

**Possíveis causas e soluções:**
- **Porta em uso:** Outro programa (Skype, IIS, Docker) está usando a porta 80 ou 443. Pare esse programa ou altere as portas em `C:\xampp\apache\conf\httpd.conf`
- **Erro de sintaxe:** Verifique com:
  ```cmd
  C:\xampp\apache\bin\httpd.exe -t
  ```
- **OpenSSL ausente:** Certifique-se de que `C:\xampp\apache\bin\openssl.exe` existe
- **Conflitos de SSL:** Se houver configurações SSL corrompidas, revise os arquivos em `C:\xampp\apache\conf\extra\vhosts_ssl\`

### Erro de permissão ao criar host

**Sintoma:** "Permission denied" ao criar um host ou ao gravar no arquivo `hosts`.

**Solução:** Execute uma vez:
```
xvhost grantperms_winhosts
```
como Administrador. Depois disso, você não precisará mais de permissões elevadas para criar hosts.

---

## Licença

[MIT](LICENSE) © Jose Alexis Correa Valencia
