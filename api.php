<?php
require_once "config.php";

function redirect_home() {
    header("Location: index.php");
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'create_ticket') {
    $ticketNo = 'INC-' . date('YmdHis') . '-' . random_int(100,999);
    $stmt = $pdo->prepare("INSERT INTO tickets
        (ticket_no,user_id,subject,description,category,priority)
        VALUES (?,?,?,?,?,?)");
    $stmt->execute([
        $ticketNo,
        $_POST['user_id'],
        trim($_POST['subject']),
        trim($_POST['description']),
        $_POST['category'],
        $_POST['priority']
    ]);
    redirect_home();
}

if ($action === 'update_ticket') {
    $stmt = $pdo->prepare("UPDATE tickets SET status=?, resolution=? WHERE id=?");
    $stmt->execute([
        $_POST['status'],
        trim($_POST['resolution'] ?? ''),
        (int)$_POST['id']
    ]);
    redirect_home();
}

if ($action === 'create_asset') {
    $assigned = ($_POST['assigned_to'] ?? '') === '' ? null : (int)$_POST['assigned_to'];
    $status = $assigned ? 'Assigned' : 'Available';
    $stmt = $pdo->prepare("INSERT INTO assets
        (asset_tag,asset_type,brand,model,serial_number,assigned_to,status)
        VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([
        trim($_POST['asset_tag']),
        trim($_POST['asset_type']),
        trim($_POST['brand'] ?? ''),
        trim($_POST['model'] ?? ''),
        trim($_POST['serial_number'] ?? '') ?: null,
        $assigned,
        $status
    ]);
    redirect_home();
}

if ($action === 'export_tickets') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="helpdesk_tickets.csv"');
    $out = fopen('php://output','w');
    fputcsv($out,['Ticket No','Requester','Subject','Category','Priority','Status','Assigned To','Resolution','Created']);
    $rows = $pdo->query("SELECT t.ticket_no,u.name AS requester,t.subject,t.category,t.priority,t.status,t.assigned_to,t.resolution,t.created_at
                         FROM tickets t LEFT JOIN users u ON u.id=t.user_id ORDER BY t.created_at DESC");
    foreach($rows as $r) fputcsv($out,$r);
    fclose($out);
    exit;
}

redirect_home();
