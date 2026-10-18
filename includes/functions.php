<?php
/**
 * includes/functions.php - shared helpers used by the CRUD pages.
 */

// Dropdown choices (kept here so form + validation use the same lists)
const LANGUAGES = ['Python', 'SQL', 'Scala', 'Java', 'R', 'Other'];
const CLOUDS    = ['AWS', 'Azure', 'Google Cloud', 'None'];

/** Short alias for htmlspecialchars() to prevent XSS when printing data. */
function e($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Reads and cleans the form fields from $_POST.
 * Returns [cleanData, errors].
 */
function validateApplication(array $post): array {
    $data = [
        'first_name'          => trim($post['first_name'] ?? ''),
        'last_name'           => trim($post['last_name'] ?? ''),
        'email'               => trim($post['email'] ?? ''),
        'phone_number'        => trim($post['phone_number'] ?? ''),
        'highest_education'   => trim($post['highest_education'] ?? ''),
        'years_of_experience' => trim($post['years_of_experience'] ?? ''),
        'primary_language'    => trim($post['primary_language'] ?? ''),
        'cloud_platform'      => trim($post['cloud_platform'] ?? ''),
        'tools_and_skills'    => trim($post['tools_and_skills'] ?? ''),
        'portfolio_url'       => trim($post['portfolio_url'] ?? ''),
        'expected_salary'     => trim($post['expected_salary'] ?? ''),
    ];
    $errors = [];

    foreach (['first_name','last_name','email','phone_number','highest_education','tools_and_skills'] as $f) {
        if ($data[$f] === '') $errors[] = ucwords(str_replace('_', ' ', $f)) . ' is required.';
    }
    if ($data['email'] !== '' && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is not valid.';
    }
    if (!ctype_digit($data['years_of_experience']) || (int)$data['years_of_experience'] > 50) {
        $errors[] = 'Years of experience must be a whole number from 0 to 50.';
    }
    if (!in_array($data['primary_language'], LANGUAGES, true)) $errors[] = 'Choose a primary language.';
    if (!in_array($data['cloud_platform'], CLOUDS, true))      $errors[] = 'Choose a cloud platform.';
    if (!is_numeric($data['expected_salary']) || (float)$data['expected_salary'] < 0) {
        $errors[] = 'Expected salary must be a positive number.';
    }
    if ($data['portfolio_url'] !== '' && !filter_var($data['portfolio_url'], FILTER_VALIDATE_URL)) {
        $errors[] = 'Portfolio URL is not valid (include https://).';
    }
    return [$data, $errors];
}

/** Redirect to a page with a flash message stored in the session. */
function redirect(string $url, string $type = '', string $message = ''): never {
    if ($message !== '') {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
    header("Location: $url");
    exit;
}
