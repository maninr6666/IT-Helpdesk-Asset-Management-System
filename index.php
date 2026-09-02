<?php
require_once "config.php";

$ticketCount = (int)$pdo->query("SELECT COUNT(*) FROM tickets")->fetchColumn();
$openCount = (int)$pdo->query("SELECT COUNT(*) FROM tickets WHERE status IN ('Open','In Progress')")->fetchColumn();
$assetCount = (int)$pdo->query("SELECT COUNT(*) FROM assets")->fetchColumn();
$userCount = (int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

$tickets = $pdo->query("
    SELECT t.*, u.name AS requester
    FROM tickets t
    LEFT JOIN users u ON u.id=t.user_id
    ORDER BY t.created_at DESC LIMIT 50
")->fetchAll();

$assets = $pdo->query("
    SELECT a.*, u.name AS assigned_name
    FROM assets a
    LEFT JOIN users u ON u.id=a.assigned_to
    ORDER BY a.created_at DESC LIMIT 50
")->fetchAll();

$users = $pdo->query("SELECT * FROM users ORDER BY name")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>IT Helpdesk & Asset Management</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <div>
    <h1>IT Helpdesk & Asset Management</h1>
    <p>Ticket tracking • Priority routing • Asset inventory • Operational dashboard</p>
  </div>
  <a class="export" href="api.php?action=export_tickets">Export Tickets CSV</a>
</header>

<main>
<section class="cards">
  <div class="card"><span>Total Tickets</span><strong><?= $ticketCount ?></strong></div>
  <div class="card"><span>Open / In Progress</span><strong><?= $openCount ?></strong></div>
  <div class="card"><span>Assets</span><strong><?= $assetCount ?></strong></div>
  <div class="card"><span>Users</span><strong><?= $userCount ?></strong></div>
</section>

<section class="grid">
<div class="panel">
<h2>Create Support Ticket</h2>
<form action="api.php" method="post">
<input type="hidden" name="action" value="create_ticket">
<label>Requester
<select name="user_id" required>
<option value="">Select user</option>
<?php foreach($users as $u): ?>
<option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?> — <?= htmlspecialchars($u['department']) ?></option>
<?php endforeach; ?>
</select></label>
<label>Subject<input name="subject" maxlength="200" required></label>
<label>Category
<select name="category" required>
<option>Hardware</option><option>Software</option><option>Network</option>
<option>Access / Account</option><option>Other</option>
</select></label>
<label>Priority
<select name="priority"><option>Low</option><option selected>Medium</option><option>High</option><option>Critical</option></select>
</label>
<label>Description<textarea name="description" rows="4" required></textarea></label>
<button type="submit">Create Ticket</button>
</form>
</div>

<div class="panel">
<h2>Add Asset</h2>
<form action="api.php" method="post">
<input type="hidden" name="action" value="create_asset">
<label>Asset Tag<input name="asset_tag" placeholder="LAP-1003" required></label>
<label>Type<input name="asset_type" placeholder="Laptop" required></label>
<label>Brand<input name="brand" placeholder="Dell"></label>
<label>Model<input name="model" placeholder="Latitude 5440"></label>
<label>Serial Number<input name="serial_number"></label>
<label>Assign To
<select name="assigned_to"><option value="">Unassigned</option>
<?php foreach($users as $u): ?><option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?></option><?php endforeach; ?>
</select></label>
<button type="submit">Add Asset</button>
</form>
</div>
</section>

<section class="panel">
<h2>Ticket Queue</h2>
<div class="table-wrap"><table>
<thead><tr><th>Ticket</th><th>Requester</th><th>Subject</th><th>Priority</th><th>Status</th><th>Created</th><th>Update</th></tr></thead>
<tbody>
<?php foreach($tickets as $t): ?>
<tr>
<td><?= htmlspecialchars($t['ticket_no']) ?></td>
<td><?= htmlspecialchars($t['requester'] ?? 'Unknown') ?></td>
<td><?= htmlspecialchars($t['subject']) ?></td>
<td><span class="badge <?= strtolower($t['priority']) ?>"><?= htmlspecialchars($t['priority']) ?></span></td>
<td><?= htmlspecialchars($t['status']) ?></td>
<td><?= htmlspecialchars($t['created_at']) ?></td>
<td>
<form class="inline" action="api.php" method="post">
<input type="hidden" name="action" value="update_ticket">
<input type="hidden" name="id" value="<?= $t['id'] ?>">
<select name="status">
<?php foreach(['Open','In Progress','Resolved','Closed'] as $s): ?>
<option <?= $t['status']===$s?'selected':'' ?>><?= $s ?></option>
<?php endforeach; ?>
</select>
<input name="resolution" placeholder="Resolution / notes" value="<?= htmlspecialchars($t['resolution'] ?? '') ?>">
<button>Save</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody></table></div>
</section>

<section class="panel">
<h2>Asset Inventory</h2>
<div class="table-wrap"><table>
<thead><tr><th>Asset Tag</th><th>Type</th><th>Brand / Model</th><th>Serial</th><th>Assigned To</th><th>Status</th></tr></thead>
<tbody>
<?php foreach($assets as $a): ?>
<tr>
<td><?= htmlspecialchars($a['asset_tag']) ?></td>
<td><?= htmlspecialchars($a['asset_type']) ?></td>
<td><?= htmlspecialchars(trim(($a['brand']??'').' '.($a['model']??''))) ?></td>
<td><?= htmlspecialchars($a['serial_number'] ?? '') ?></td>
<td><?= htmlspecialchars($a['assigned_name'] ?? 'Unassigned') ?></td>
<td><?= htmlspecialchars($a['status']) ?></td>
</tr>
<?php endforeach; ?>
</tbody></table></div>
</section>
</main>
<script src="script.js"></script>
</body>
</html>
