<?php
/**
 * index.php - READ: shows the application form (to create) and the table of
 * all submitted applications, with Edit and Delete buttons per row.
 */
session_start();
require_once 'config/dbconfig.php';
require_once 'includes/functions.php';

// Flash message / validation errors / old input saved by the other pages
$flash  = $_SESSION['flash']  ?? null;
$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old']    ?? [];
unset($_SESSION['flash'], $_SESSION['errors'], $_SESSION['old']);

// READ all records, newest first
$applications = $pdo->query(
    "SELECT * FROM data_engineer_applications ORDER BY application_id DESC"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Engineer Job Application</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<main>
    <h1>Data Engineer - Job Application</h1>

    <?php if ($flash): ?>
        <div class="alert <?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
    <?php endif; ?>
    <?php if ($errors): ?>
        <div class="alert error"><ul><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>

    <section class="card">
        <h2>Apply Now</h2>
        <form action="create.php" method="post">
            <?php $v = $old; include 'includes/form_fields.php'; ?>
            <button type="submit" class="btn primary">Submit Application</button>
        </form>
    </section>

    <section class="card">
        <h2>Submitted Applications (<?= count($applications) ?>)</h2>
        <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Education</th>
                    <th>Exp. (yrs)</th><th>Language</th><th>Cloud</th><th>Tools &amp; Skills</th>
                    <th>Portfolio</th><th>Expected Salary</th><th>Date Added</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!$applications): ?>
                <tr><td colspan="13" class="empty">No applications yet.</td></tr>
            <?php endif; ?>
            <?php foreach ($applications as $a): ?>
                <tr>
                    <td><?= e($a['application_id']) ?></td>
                    <td><?= e($a['first_name'] . ' ' . $a['last_name']) ?></td>
                    <td><?= e($a['email']) ?></td>
                    <td><?= e($a['phone_number']) ?></td>
                    <td><?= e($a['highest_education']) ?></td>
                    <td><?= e($a['years_of_experience']) ?></td>
                    <td><?= e($a['primary_language']) ?></td>
                    <td><?= e($a['cloud_platform']) ?></td>
                    <td><?= e($a['tools_and_skills']) ?></td>
                    <td><?php if ($a['portfolio_url']): ?><a href="<?= e($a['portfolio_url']) ?>" target="_blank" rel="noopener">Link</a><?php else: ?>-<?php endif; ?></td>
                    <td>&#8369;<?= number_format($a['expected_salary'], 2) ?></td>
                    <td><?= e(date('M d, Y h:i A', strtotime($a['date_added']))) ?></td>
                    <td class="actions">
                        <a class="btn" href="edit.php?id=<?= (int) $a['application_id'] ?>">Edit</a>
                        <form action="delete.php" method="post" onsubmit="return confirm('Delete this application?');">
                            <input type="hidden" name="application_id" value="<?= (int) $a['application_id'] ?>">
                            <button type="submit" class="btn danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </section>
</main>
</body>
</html>
