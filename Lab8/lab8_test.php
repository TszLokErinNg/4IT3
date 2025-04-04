<?php
session_start();

define('DATA_FILE', 'data.txt');

function saveEntry($timestamp, $units, $username) {
    $entry = $timestamp . "," . implode(",", $units) . "," . $username . "\n";
    file_put_contents(DATA_FILE, $entry, FILE_APPEND);
}

function readEntries() {
    $rows = [];
    if (file_exists(DATA_FILE)) {
        $lines = file(DATA_FILE, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            $parts = explode(",", $line);
            if (count($parts) >= 7) {
                $rows[] = [
                    'timestamp' => $parts[0],
                    'units' => array_map('trim', array_slice($parts, 1, 5)),
                    'username' => trim($parts[6])
                ];
            }
        }
    }
    return $rows;
}

$allOn = isset($_GET['option']) && $_GET['option'] === 'allOn';
$allOff = isset($_GET['option']) && $_GET['option'] === 'allOff';
$error = '';
$enteredUsername = isset($_COOKIE['last_username']) ? $_COOKIE['last_username'] : '';
$defaultUnits = array_fill(0, 5, 'off');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(isset($_POST['username']) ? $_POST['username'] : '');
    $enteredUsername = $username;
    $units = [];
    for ($i = 1; $i <= 5; $i++) {
        $units[] = strtolower(trim(isset($_POST["unit$i"]) ? $_POST["unit$i"] : 'off'));
    }

    if ($username === '') {
        $error = "Please enter a username.";
    } else {
        setcookie("last_username", $username, time() + (86400 * 30), "/");
        $timestamp = date('Y-m-d H:i:s');
        saveEntry($timestamp, array_map('strtoupper', $units), htmlspecialchars($username));
        $enteredUsername = '';
        $defaultUnits = array_fill(0, 5, 'off');
    }
}

$rows = readEntries();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 8 - Switch Tracker with Cookies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<nav class="navbar navbar-expand-sm bg-dark navbar-dark mb-4">
    <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="?option=allOn">Toggle All On</a></li>
        <li class="nav-item"><a class="nav-link" href="?option=allOff">Toggle All Off</a></li>
    </ul>
</nav>

<?php if ($error): ?>
    <div class="alert alert-danger text-center"> <?= $error ?> </div>
<?php endif; ?>

<form method="POST" class="mb-4">
    <div class="mb-3">
        <input type="text" name="username" class="form-control" placeholder="Employee Name" value="<?= htmlspecialchars($enteredUsername) ?>">
    </div>

    <div class="d-flex flex-wrap gap-4">
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <div>
                <h6>Switch - <?= $i ?></h6>
                <label class="btn btn-success">
                    <input type="radio" name="unit<?= $i ?>" value="on"> ON
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="unit<?= $i ?>" value="off"> OFF
                </label>
            </div>
        <?php endfor; ?>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Update</button>
</form>

<h4>Recorded Entries:</h4>
<table class="table table-bordered text-center">
    <thead>
    <tr>
        <th>Timestamp</th>
        <th>Unit 1</th>
        <th>Unit 2</th>
        <th>Unit 3</th>
        <th>Unit 4</th>
        <th>Unit 5</th>
        <th>Employee Name</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $row): ?>
        <tr>
            <td><?= $row['timestamp'] ?></td>
            <?php foreach ($row['units'] as $unit): ?>
                <td><?= htmlspecialchars($unit) ?></td>
            <?php endforeach; ?>
            <td><?= htmlspecialchars($row['username']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
