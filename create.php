<?php
/**
 * create.php - CREATE: inserts a new application (PDO prepared statement).
 * Receives the POST from the form in index.php.
 */
session_start();
require_once 'config/dbconfig.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php');

[$data, $errors] = validateApplication($_POST);

if ($errors) {
    // Keep what the user typed and show the errors on index.php
    $_SESSION['old']    = $data;
    $_SESSION['errors'] = $errors;
    redirect('index.php');
}

try {
    $sql = "INSERT INTO data_engineer_applications
                (first_name, last_name, email, phone_number, highest_education,
                 years_of_experience, primary_language, cloud_platform,
                 tools_and_skills, portfolio_url, expected_salary)
            VALUES
                (:first_name, :last_name, :email, :phone_number, :highest_education,
                 :years_of_experience, :primary_language, :cloud_platform,
                 :tools_and_skills, :portfolio_url, :expected_salary)";
    $stmt = $pdo->prepare($sql);
    $data['portfolio_url'] = $data['portfolio_url'] === '' ? null : $data['portfolio_url'];
    $stmt->execute($data);   // array keys match the :placeholder names
    redirect('index.php', 'success', 'Application submitted successfully!');
} catch (PDOException $ex) {
    // 1062 = duplicate entry (email must be unique)
    $msg = $ex->errorInfo[1] === 1062 ? 'That email has already applied.' : 'Database error: ' . $ex->getMessage();
    $_SESSION['old']    = $data;
    $_SESSION['errors'] = [$msg];
    redirect('index.php');
}
