<?php
/**
 * update.php - UPDATE: saves changes to an existing application.
 * Receives the POST from edit.php.
 */
session_start();
require_once 'config/dbconfig.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php');

$id = (int) ($_POST['application_id'] ?? 0);
[$data, $errors] = validateApplication($_POST);

if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old']    = $data;
    redirect("edit.php?id=$id");
}

try {
    $sql = "UPDATE data_engineer_applications
            SET first_name = :first_name, last_name = :last_name, email = :email,
                phone_number = :phone_number, highest_education = :highest_education,
                years_of_experience = :years_of_experience, primary_language = :primary_language,
                cloud_platform = :cloud_platform, tools_and_skills = :tools_and_skills,
                portfolio_url = :portfolio_url, expected_salary = :expected_salary
            WHERE application_id = :application_id";
    $stmt = $pdo->prepare($sql);
    $data['portfolio_url']  = $data['portfolio_url'] === '' ? null : $data['portfolio_url'];
    $data['application_id'] = $id;
    $stmt->execute($data);
    redirect('index.php', 'success', 'Application updated successfully!');
} catch (PDOException $ex) {
    $msg = $ex->errorInfo[1] === 1062 ? 'That email is used by another application.' : 'Database error: ' . $ex->getMessage();
    $_SESSION['errors'] = [$msg];
    $_SESSION['old']    = $data;
    redirect("edit.php?id=$id");
}
