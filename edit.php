<?php
/**
 * edit.php - shows the form pre-filled with one record; submits to update.php.
 */
session_start();
require_once 'config/dbconfig.php';
require_once 'includes/functions.php';

$id = (int) ($_GET['id'] ?? 0);

// Fetch the single record to edit
$stmt = $pdo->prepare("SELECT * FROM data_engineer_applications WHERE application_id = :id");
$stmt->execute([':id' => $id]);
$record = $stmt->fetch();

if (!$record) redirect('index.php', 'error', 'Record not found.');

// If validation failed on the last save, show what the user typed instead
$errors = $_SESSION['errors'] ?? [];
$v = $_SESSION['old'] ?? $record;
unset($_SESSION['errors'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Application</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<main>
    <h1>Edit Application #<?= (int) $record['application_id'] ?></h1>

    <?php if ($errors): ?>
        <div class="alert error"><ul><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>

    <section class="card">
        <form action="update.php" method="post">
            <input type="hidden" name="application_id" value="<?= (int) $record['application_id'] ?>">
            <?php include 'includes/form_fields.php'; ?>
            <button type="submit" class="btn primary">Save Changes</button>
            <a class="btn" href="index.php">Cancel</a>
        </form>
    </section>
</main>
</body>
</html>
