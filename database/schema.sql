DROP DATABASE IF EXISTS dream_job_db;
CREATE DATABASE dream_job_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE dream_job_db;

CREATE TABLE data_engineer_applications (
    application_id      INT UNSIGNED  NOT NULL AUTO_INCREMENT,  -- primary key
    first_name          VARCHAR(50)   NOT NULL,
    last_name           VARCHAR(50)   NOT NULL,
    email               VARCHAR(100)  NOT NULL,
    phone_number        VARCHAR(20)   NOT NULL,
    highest_education   VARCHAR(60)   NOT NULL,                 
    years_of_experience TINYINT       NOT NULL DEFAULT 0,
    primary_language    VARCHAR(30)   NOT NULL,                 
    cloud_platform      VARCHAR(30)   NOT NULL,                 
    tools_and_skills    VARCHAR(255)  NOT NULL,                 
    portfolio_url       VARCHAR(255)  NULL,                     -- GitHub / LinkedIn (optional)
    expected_salary     DECIMAL(10,2) NOT NULL DEFAULT 0.00,    
    date_added          DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (application_id),
    UNIQUE KEY uq_email (email)
) ENGINE=InnoDB;

-- Sample records 
INSERT INTO data_engineer_applications
    (first_name, last_name, email, phone_number, highest_education, years_of_experience,
     primary_language, cloud_platform, tools_and_skills, portfolio_url, expected_salary)
VALUES
    ('Maria',  'Santos', 'maria.santos@example.com', '09171234567', 'BS Computer Science',      3, 'Python', 'AWS',   'Spark, Airflow, Redshift',     'https://github.com/example-maria', 85000.00),
    ('Juan',   'Reyes',  'juan.reyes@example.com',   '09281234567', 'BS Information Technology', 1, 'SQL',    'Azure', 'Data Factory, Power BI, dbt',  NULL,                                60000.00);
