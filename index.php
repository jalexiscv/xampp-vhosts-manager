<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Virtual Hosts Manager</title>
<style>
:root{--bg:#0f1117;--card:#1a1d27;--border:#2a2d3a;--text:#e4e6ef;--muted:#8b8fa3;--primary:#6366f1;--success:#22c55e;--danger:#ef4444;--warning:#f59e0b;--radius:12px}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:var(--bg);color:var(--text);padding:24px;min-height:100vh}
.container{max-width:1200px;margin:0 auto}
.header{display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;flex-wrap:wrap;gap:16px}
.header h1{font-size:28px;font-weight:700;background:linear-gradient(135deg,#6366f1,#a855f7);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.subtitle{color:var(--muted);font-size:14px;margin-top:4px}
.apache-bar{display:flex;align-items:center;gap:12px;padding:12px 20px;background:var(--card);border:1px solid var(--border);border-radius:12px;margin-bottom:24px}
.status-dot{width:10px;height:10px;border-radius:50%;background:var(--muted);flex-shrink:0}
.status-dot.running{background:var(--success);box-shadow:0 0 8px rgba(34,197,94,.4)}
.status-dot.stopped{background:var(--danger)}
.status-label{font-weight:600;font-size:14px}
.status-text{color:var(--muted);font-size:13px}
.apache-actions{margin-left:auto;display:flex;gap:8px}
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:opacity .15s}
.btn:hover{opacity:.85}
.btn:disabled{opacity:.4;cursor:not-allowed}
.btn-primary{background:var(--primary);color:#fff}
.btn-success{background:var(--success);color:#fff}
.btn-danger{background:var(--danger);color:#fff}
.btn-warning{background:var(--warning);color:#000}
.btn-outline{background:transparent;color:var(--text);border:1px solid var(--border)}
.btn-sm{padding:5px 12px;font-size:12px}
.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:24px}
.stat-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:20px;text-align:center}
.stat-number{font-size:32px;font-weight:700}
.stat-label{color:var(--muted);font-size:13px;margin-top:4px}
.host-list{display:flex;flex-direction:column;gap:12px}
.host-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:20px 24px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;transition:border-color .15s}
.host-card:hover{border-color:var(--primary)}
.host-info{flex:1;min-width:200px}
.host-name{font-size:16px;font-weight:600;display:flex;align-items:center;gap:8px}
.host-name a{color:var(--primary);text-decoration:none}
.host-name a:hover{text-decoration:underline}
.host-details{font-size:13px;color:var(--muted);margin-top:6px;font-family:monospace}
.badge{display:inline-flex;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:600}
.badge-ssl{background:rgba(99,102,241,.15);color:#818cf8}
.badge-no-ssl{background:rgba(139,143,163,.1);color:var(--muted)}
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);-webkit-backdrop-filter:blur(4px);backdrop-filter:blur(4px);z-index:100;justify-content:center;align-items:center;padding:20px}
.modal-overlay.active{display:flex}
.modal{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:28px;width:100%;max-width:520px;max-height:90vh;overflow-y:auto}
.modal h2{font-size:20px;margin-bottom:8px}
.modal p{color:var(--muted);font-size:14px;margin-bottom:20px}
.form-group{margin-bottom:16px}
.form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:6px}
.form-group input,.form-group select{width:100%;padding:10px 14px;border-radius:8px;border:1px solid var(--border);background:var(--bg);color:var(--text);font-size:14px;outline:none;transition:border-color .15s}
.form-group input:focus,.form-group select:focus{border-color:var(--primary)}
.form-group .helper{font-size:12px;color:var(--muted);margin-top:4px}
.form-group .checkbox-group{display:flex;align-items:center;gap:8px}
.form-group .checkbox-group input[type=checkbox]{width:auto}
.form-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:20px}
.output-box{background:#0a0a0f;border:1px solid var(--border);border-radius:8px;padding:16px;font-family:monospace;font-size:13px;white-space:pre-wrap;max-height:300px;overflow-y:auto;margin-top:16px;display:none}
.output-box.show{display:block}
.output-box.success{border-color:var(--success)}
.output-box.error{border-color:var(--danger)}
.loading{display:none;text-align:center;padding:60px 0}
.loading.active{display:block}
.spinner{width:36px;height:36px;border:3px solid var(--border);border-top-color:var(--primary);border-radius:50%;animation:spin .8s linear infinite;margin:0 auto 12px}
@keyframes spin{to{transform:rotate(360deg)}}
.empty-state{text-align:center;padding:60px 20px;color:var(--muted)}
.empty-state h3{font-size:18px;margin-bottom:8px}
.toast{position:fixed;bottom:24px;right:24px;padding:12px 20px;border-radius:10px;font-size:14px;font-weight:500;z-index:200;display:none;animation:slideIn .3s ease}
.toast.show{display:block}
.toast.success{background:rgba(34,197,94,.15);border:1px solid var(--success);color:var(--success)}
.toast.error{background:rgba(239,68,68,.15);border:1px solid var(--danger);color:var(--danger)}
@keyframes slideIn{from{transform:translateX(100%);opacity:0}to{transform:translateX(0);opacity:1}}
.host-actions{display:flex;gap:8px}
</style>
</head>
<body>
<div class="container">
<div class="header">
<div><h1>Hosts Virtuales Manager</h1><div class="subtitle">Panel de administracion para XAMPP</div></div>
<div style="display:flex;gap:8px">
<button class="btn btn-outline" onclick="refreshList()">Refrescar</button>
<button class="btn btn-primary" onclick="openCreateModal()">+ Nuevo Host</button>
</div>
</div>

<div class="apache-bar">
<span class="status-dot" id="statusDot"></span>
<span class="status-label">Apache</span>
<span class="status-text" id="statusText">Verificando...</span>
<div class="apache-actions">
<button class="btn btn-sm btn-success" onclick="apacheAction('start')" id="btnStart">Iniciar</button>
<button class="btn btn-sm btn-warning" onclick="apacheAction('restart')" id="btnRestart">Reiniciar</button>
<button class="btn btn-sm btn-danger" onclick="apacheAction('stop')" id="btnStop">Detener</button>
</div>
</div>

<div class="stats">
<div class="stat-card"><div class="stat-number" id="totalHosts">--</div><div class="stat-label">Hosts Virtuales</div></div>
<div class="stat-card"><div class="stat-number" id="totalSSL">--</div><div class="stat-label">Con SSL</div></div>
<div class="stat-card"><div class="stat-number" id="apacheUptime">--</div><div class="stat-label">Estado Apache</div></div>
</div>

<div class="loading active" id="loading"><div class="spinner"></div><div>Cargando hosts...</div></div>
<div class="host-list" id="hostList"></div>
<div class="output-box" id="outputBox"></div>
</div>

<!-- Modal: Crear Host -->
<div class="modal-overlay" id="createModal">
<div class="modal">
<h2>Nuevo Host Virtual</h2>
<p>Completa los datos para crear un nuevo host virtual. El nombre debe terminar en <code>.local</code>.</p>
<form onsubmit="createHost(event)">
<div class="form-group">
<label>Nombre del host</label>
<input type="text" id="hostName" placeholder="ej: misitio.local" required>
<div class="helper">Debe terminar en .local o .test</div>
</div>
<div class="form-group">
<label>Document Root</label>
<input type="text" id="docRoot" placeholder="C:/xampp/hosts/misitio" required>
<div class="helper">Ruta absoluta donde estará el proyecto</div>
</div>
<div class="form-group">
<label>Email del administrador</label>
<input type="email" id="adminEmail" value="admin@localhost">
</div>
<div class="form-group">
<div class="checkbox-group">
<input type="checkbox" id="addSSL" value="1">
<label for="addSSL">Habilitar SSL (certificado autofirmado)</label>
</div>
</div>
<div class="form-actions">
<button type="button" class="btn btn-outline" onclick="closeModals()">Cancelar</button>
<button type="submit" class="btn btn-primary" id="btnCreate">Crear Host</button>
</div>
</form>
</div>
</div>

<!-- Modal: Eliminar Host -->
<div class="modal-overlay" id="deleteModal">
<div class="modal">
<h2>Eliminar Host Virtual</h2>
<p id="deleteMsg">Esta accion eliminara el host virtual seleccionado.</p>
<div class="form-actions">
<button class="btn btn-outline" onclick="closeModals()">Cancelar</button>
<button class="btn btn-danger" onclick="confirmDelete()" id="btnDelete">Eliminar</button>
</div>
</div>
</div>

<!-- Toast notification -->
<div class="toast" id="toast"></div>

<script>
var deleteTarget = null;

function showToast(msg, type) {
  var t = document.getElementById('toast');
  t.textContent = msg;
  t.className = 'toast ' + type + ' show';
  setTimeout(function(){ t.classList.remove('show'); }, 4000);
}

async function refreshList() {
  var el = document.getElementById('loading');
  var list = document.getElementById('hostList');
  el.classList.add('active');
  list.innerHTML = '';
  try {
    var [hr, sr] = await Promise.all([
      fetch('api.php?action=list'),
      fetch('api.php?action=apache_status')
    ]);
    var hd = await hr.json();
    var sd = await sr.json();
    updateApacheStatus(sd);
    if (hd.success) {
      renderHosts(hd.hosts || []);
      updateStats(hd.hosts || []);
      if (hd.hosts && hd.hosts.length > 0) {
        showToast(hd.hosts.length + ' host' + (hd.hosts.length !== 1 ? 'es' : '') + ' cargados', 'success');
      }
    } else {
      list.innerHTML = '<div class="empty-state"><h3>Error</h3><p>' + (hd.error || 'Error al cargar hosts') + '</p></div>';
      showToast('Error al cargar hosts', 'error');
    }
  } catch(e) {
    list.innerHTML = '<div class="empty-state"><h3>Error de conexion</h3><p>' + e.message + '</p></div>';
    showToast('Error de conexion: ' + e.message, 'error');
  }
  el.classList.remove('active');
}

function renderHosts(hosts) {
  var list = document.getElementById('hostList');
  if (!hosts || !hosts.length) {
    list.innerHTML = '<div class="empty-state"><h3>No hay hosts virtuales</h3><p>Crea tu primer host virtual con el boton "+ Nuevo Host"</p></div>';
    return;
  }
  list.innerHTML = hosts.map(function(h) {
    var url = 'http://' + h.name + '/';
    var bdg = h.ssl
      ? '<span class="badge badge-ssl">SSL</span>'
      : '<span class="badge badge-no-ssl">Sin SSL</span>';
    return '<div class="host-card">' +
      '<div class="host-info">' +
        '<div class="host-name">' +
          '<a href="' + url + '" target="_blank">' + h.name + '</a> ' + bdg +
        '</div>' +
        '<div class="host-details">' + (h.docRoot || '--') + '</div>' +
      '</div>' +
      '<div class="host-actions">' +
        '<a href="' + url + '" target="_blank" class="btn btn-sm btn-outline">Abrir</a>' +
        '<button class="btn btn-sm btn-danger" onclick="openDeleteModal(\'' + h.name.replace(/'/g, "\\'") + '\')">Eliminar</button>' +
      '</div>' +
    '</div>';
  }).join('');
}

function updateStats(hosts) {
  document.getElementById('totalHosts').textContent = hosts.length;
  document.getElementById('totalSSL').textContent = hosts.filter(function(x){ return x.ssl; }).length;
}

function updateApacheStatus(d) {
  var dot = document.getElementById('statusDot');
  var txt = document.getElementById('statusText');
  var uptime = document.getElementById('apacheUptime');
  dot.className = 'status-dot';
  if (d.running) {
    dot.classList.add('running');
    txt.textContent = 'Corriendo';
    uptime.textContent = 'Activo';
    document.getElementById('btnStart').disabled = true;
    document.getElementById('btnStop').disabled = false;
    document.getElementById('btnRestart').disabled = false;
  } else {
    dot.classList.add('stopped');
    txt.textContent = 'Detenido';
    uptime.textContent = 'Detenido';
    document.getElementById('btnStart').disabled = false;
    document.getElementById('btnStop').disabled = true;
    document.getElementById('btnRestart').disabled = true;
  }
}

async function apacheAction(action) {
  try {
    var r = await fetch('api.php?action=apache_' + action);
    var d = await r.json();
    showOutput(d);
    if (d.success) {
      showToast('Apache ' + (action === 'start' ? 'iniciado' : action === 'stop' ? 'detenido' : 'reiniciado') + ' correctamente', 'success');
    } else {
      showToast('Error al ' + action + ' Apache', 'error');
    }
    setTimeout(async function() {
      var r2 = await fetch('api.php?action=apache_status');
      updateApacheStatus(await r2.json());
      refreshList();
    }, 2000);
  } catch(e) {
    showOutput({ success: false, output: e.message });
    showToast('Error: ' + e.message, 'error');
  }
}

function openCreateModal() {
  document.getElementById('hostName').value = '';
  document.getElementById('docRoot').value = '';
  document.getElementById('adminEmail').value = 'admin@localhost';
  document.getElementById('addSSL').checked = false;
  document.getElementById('outputBox').classList.remove('show');
  document.getElementById('createModal').classList.add('active');
}

async function createHost(e) {
  e.preventDefault();
  var host = document.getElementById('hostName').value.trim();
  var root = document.getElementById('docRoot').value.trim();
  var email = document.getElementById('adminEmail').value.trim();
  var ssl = document.getElementById('addSSL').checked ? '1' : '0';
  var btn = document.getElementById('btnCreate');
  btn.disabled = true;
  btn.textContent = 'Creando...';
  try {
    var fd = new URLSearchParams();
    fd.append('host', host);
    fd.append('docRoot', root);
    fd.append('email', email);
    fd.append('ssl', ssl);
    var res = await fetch('api.php?action=create', { method: 'POST', body: fd });
    var d = await res.json();
    showOutput(d);
    if (d.success) {
      showToast('Host ' + host + ' creado exitosamente', 'success');
      closeModals();
      setTimeout(refreshList, 1500);
    } else {
      showToast('Error al crear host: ' + (d.output || 'desconocido'), 'error');
    }
  } catch(e) {
    showOutput({ success: false, output: e.message });
    showToast('Error: ' + e.message, 'error');
  }
  btn.disabled = false;
  btn.textContent = 'Crear Host';
}

function openDeleteModal(name) {
  deleteTarget = name;
  document.getElementById('deleteMsg').textContent = '¿Esta seguro de eliminar el host "' + name + '"? Se eliminara la configuracion de Apache y se borrara del archivo hosts de Windows.';
  document.getElementById('deleteModal').classList.add('active');
}

async function confirmDelete() {
  if (!deleteTarget) return;
  var btn = document.getElementById('btnDelete');
  btn.disabled = true;
  btn.textContent = 'Eliminando...';
  try {
    var r = await fetch('api.php?action=delete&host=' + encodeURIComponent(deleteTarget));
    var d = await r.json();
    showOutput(d);
    if (d.success) {
      showToast('Host ' + deleteTarget + ' eliminado', 'success');
      closeModals();
      setTimeout(refreshList, 1500);
    } else {
      showToast('Error al eliminar: ' + (d.output || 'desconocido'), 'error');
    }
  } catch(e) {
    showOutput({ success: false, output: e.message });
    showToast('Error: ' + e.message, 'error');
  }
  btn.disabled = false;
  btn.textContent = 'Eliminar';
  deleteTarget = null;
}

function closeModals() {
  document.getElementById('createModal').classList.remove('active');
  document.getElementById('deleteModal').classList.remove('active');
}

function showOutput(d) {
  var box = document.getElementById('outputBox');
  box.className = 'output-box';
  box.textContent = d.output || (d.success ? 'Operacion completada.' : 'Error.');
  box.classList.add('show', d.success ? 'success' : 'error');
}

refreshList();
</script>
</body>
</html>
