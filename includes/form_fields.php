<?php
/**
 * includes/form_fields.php - the input fields, shared by the "add" form (index.php)
 * and the "edit" form (edit.php). Expects an array $v with the current values.
 */
?>
<div class="grid">
    <label>First name
        <input type="text" name="first_name" maxlength="50" required value="<?= e($v['first_name'] ?? '') ?>"></label>
    <label>Last name
        <input type="text" name="last_name" maxlength="50" required value="<?= e($v['last_name'] ?? '') ?>"></label>
    <label>Email
        <input type="email" name="email" maxlength="100" required value="<?= e($v['email'] ?? '') ?>"></label>
    <label>Phone number
        <input type="text" name="phone_number" maxlength="20" required value="<?= e($v['phone_number'] ?? '') ?>"></label>
    <label>Highest education
        <input type="text" name="highest_education" maxlength="60" placeholder="e.g. BS Information Technology" required
               value="<?= e($v['highest_education'] ?? '') ?>"></label>
    <label>Years of experience
        <input type="number" name="years_of_experience" min="0" max="50" required value="<?= e($v['years_of_experience'] ?? 0) ?>"></label>
    <label>Primary language
        <select name="primary_language" required>
            <?php foreach (LANGUAGES as $opt): ?>
                <option <?= ($v['primary_language'] ?? 'Python') === $opt ? 'selected' : '' ?>><?= e($opt) ?></option>
            <?php endforeach; ?>
        </select></label>
    <label>Cloud platform
        <select name="cloud_platform" required>
            <?php foreach (CLOUDS as $opt): ?>
                <option <?= ($v['cloud_platform'] ?? 'AWS') === $opt ? 'selected' : '' ?>><?= e($opt) ?></option>
            <?php endforeach; ?>
        </select></label>
    <label class="wide">Tools &amp; skills
        <input type="text" name="tools_and_skills" maxlength="255" placeholder="e.g. Spark, Airflow, dbt, Kafka" required
               value="<?= e($v['tools_and_skills'] ?? '') ?>"></label>
    <label>Portfolio / GitHub URL (optional)
        <input type="url" name="portfolio_url" maxlength="255" value="<?= e($v['portfolio_url'] ?? '') ?>"></label>
    <label>Expected monthly salary (PHP)
        <input type="number" name="expected_salary" min="0" step="0.01" required value="<?= e($v['expected_salary'] ?? '') ?>"></label>
</div>
