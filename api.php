<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

define('XVHM_DIR', 'C:\xampp\hosts');
define('PHP_BIN',  'C:\xampp\php\php.exe');
define('XAMPP_DIR', 'C:\xampp');

function runXvhost(string $command, string $stdinInput = ''): array
{
    $xvhostScript = XVHM_DIR . '\src\xvhost.php';
    if (!file_exists($xvhostScript)) {
        return ['success' => false, 'output' => 'Error: xvhost.php no encontrado'];
    }
    if (!file_exists(PHP_BIN)) {
        return ['success' => false, 'output' => 'Error: PHP no encontrado'];
    }

    // Split command into separate arguments for proper argv handling
    $parts = explode(' ', $command, 2);
    $cmd = sprintf(
        '"%s" -n -d output_buffering=0 "%s" "%s"',
        PHP_BIN,
        $xvhostScript,
        $parts[0]
    );
    if (isset($parts[1])) {
        $cmd .= ' "' . $parts[1] . '"';
    }

    $descriptorspec = [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
    ];

    $env = [
        'XVHM_APP_DIR' => XVHM_DIR,
        'PATH' => getenv('PATH'),
        'SYSTEMROOT' => getenv('SYSTEMROOT') ?: 'C:\\Windows',
    ];
    $process = proc_open($cmd, $descriptorspec, $pipes, null, $env);

    if (!is_resource($process)) {
        return ['success' => false, 'output' => 'Error: No se pudo ejecutar el proceso.'];
    }

    if ($stdinInput !== '') {
        fwrite($pipes[0], $stdinInput);
    }
    fclose($pipes[0]);

    $stdout = stream_get_contents($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);

    $exitCode = proc_close($process);
    $output = $stdout . ($stderr ? "\n[STDERR]\n" . $stderr : '');

    return ['success' => $exitCode === 0, 'output' => trim($output), 'exitCode' => $exitCode];
}

function isApacheRunning(): bool
{
    $output = [];
    exec('sc query Apache2.4 2>&1', $output);
    return strpos(implode("\n", $output), 'RUNNING') !== false;
}

function getApacheStatus(): string
{
    $output = [];
    exec('sc query Apache2.4 2>&1', $output);
    $text = implode("\n", $output);
    if (strpos($text, 'RUNNING') !== false) return 'running';
    if (strpos($text, 'STOPPED') !== false) return 'stopped';
    return 'unknown';
}

function parseXvhostList(string $output): array
{
    $hosts = [];
    $lines = explode("\n", $output);
    $currentHost = null;
    $currentInfo = [];

    foreach ($lines as $line) {
        $line = trim($line);
        // Match: "1. [prueba.local]" (listHosts format)
        if (preg_match('/^\d+\.\s+\[([^\]]+)\]/', $line, $m)) {
            if ($currentHost) {
                $hosts[$currentHost] = $currentInfo;
            }
            $currentHost = $m[1];
            $currentInfo = ['name' => $currentHost, 'ssl' => false, 'docRoot' => ''];
            continue;
        }
        // Always try to parse (works for both listHosts and showHostInfo output)
        // Match: "- Host name             : prueba.local" (showHostInfo format - also sets currentHost)
        if (!$currentHost && preg_match('/Host\s+name\s*:\s*(.+)/i', $line, $m)) {
            $currentHost = trim($m[1]);
            $currentInfo = ['name' => $currentHost, 'ssl' => false, 'docRoot' => ''];
            continue;
        }
        if ($currentHost) {
            // Match: "- Added SSL certificate : Yes/No"
            if (preg_match('/Added\s+SSL\s+certificate\s*:\s*(.+)/i', $line, $m)) {
                $currentInfo['ssl'] = stripos(trim($m[1]), 'yes') !== false;
            }
            // Match: "- Document root         : C:\xampp\hosts\prueba" (from showHostInfo)
            elseif (preg_match('/Document\s+root\s*:\s*(.+)/i', $line, $m)) {
                $currentInfo['docRoot'] = trim($m[1]);
            }
            // Match: "- Host url              : http://prueba.local"
            elseif (preg_match('/Host\s+url\s*:\s*(.+)/i', $line, $m)) {
                $currentInfo['url'] = trim($m[1]);
            }
            // Match: "- Host name             : prueba.local" (from showHostInfo, name only)
            elseif (preg_match('/Host\s+name\s*:\s*(.+)/i', $line, $m)) {
                $currentInfo['name'] = trim($m[1]);
            }
            // Match: "- Admin email           : admin@prueba.local" (from showHostInfo)
            elseif (preg_match('/Admin\s+email\s*:\s*(.+)/i', $line, $m)) {
                $currentInfo['adminEmail'] = trim($m[1]);
            }
        }
    }
    if ($currentHost) {
        $hosts[$currentHost] = $currentInfo;
    }
    return $hosts;
}

$action = $_GET['action'] ?? '';
$host   = $_GET['host'] ?? '';

switch ($action) {
    case 'list':
        $result = runXvhost('listHosts');
        if (!$result['success']) {
            echo json_encode(['success' => false, 'error' => $result['output']]);
            exit;
        }
        $hosts = parseXvhostList($result['output']);
        echo json_encode(['success' => true, 'hosts' => array_values($hosts)]);
        break;

    case 'create':
        $newHost = $_POST['host'] ?? '';
        $docRoot = $_POST['docRoot'] ?? '';
        $email   = $_POST['email'] ?? 'admin@localhost';
        $addSSL  = ($_POST['ssl'] ?? '0') === '1' ? 'y' : 'n';
        if (!$newHost || !$docRoot) {
            echo json_encode(['success' => false, 'error' => 'Host name and document root are required.']);
            exit;
        }
        $stdin = $docRoot . "\n" . $email . "\n" . $addSSL . "\nn\nn\n";
        $result = runXvhost('newHost ' . $newHost, $stdin);
        echo json_encode(['success' => $result['success'], 'output' => $result['output']]);
        break;

    case 'delete':
        if (!$host) { echo json_encode(['success' => false, 'error' => 'Host name required.']); exit; }
        $result = runXvhost('removeHost ' . $host, "y\nn\nn\n");
        echo json_encode(['success' => $result['success'], 'output' => $result['output']]);
        break;

    case 'info':
        if (!$host) { echo json_encode(['success' => false, 'error' => 'Host name required.']); exit; }
        $result = runXvhost('showHostInfo ' . $host, "n\n");
        $info = parseXvhostList($result['output']);
        $hostInfo = $info[$host] ?? ['name' => $host, 'ssl' => false, 'docRoot' => ''];
        echo json_encode(['success' => $result['success'], 'info' => $hostInfo]);
        break;

    case 'apache_status':
        echo json_encode(['success' => true, 'status' => getApacheStatus(), 'running' => isApacheRunning()]);
        break;

    case 'apache_start':
        echo json_encode(runXvhost('startApache'));
        break;

    case 'apache_stop':
        echo json_encode(runXvhost('stopApache'));
        break;

    case 'apache_restart':
        echo json_encode(runXvhost('restartApache'));
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Unknown action: ' . $action]);
        break;
}
