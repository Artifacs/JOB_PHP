<?php
/**
 * delete.php - DELETE: removes one application by its primary key.
 * Uses POST (not a link) so records can't be deleted by accident/crawlers.
 */
session_start();
require_once 'config/dbconfig.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php');

$id = (int) ($_POST['application_id'] ?? 0);

$stmt = $pdo->prepare("DELETE FROM data_engineer_applications WHERE application_id = :id");
$stmt->execute([':id' => $id]);

if ($stmt->rowCount() > 0) {
    redirect('index.php', 'success', 'Application deleted.');
}
redirect('index.php', 'error', 'Record not found.');
