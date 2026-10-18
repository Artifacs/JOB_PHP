# Dream Job: Data Engineer - Application System (PDO CRUD)

## Run on XAMPP
1. Start **Apache** and **MySQL** in the XAMPP Control Panel.
2. Copy this folder to `C:\xampp\htdocs\data_engineer_application`.
3. Open http://localhost/phpmyadmin -> **Import** -> choose `database/schema.sql` -> Go.
4. Open http://localhost/data_engineer_application/

## Files
- `index.php` read + create form | `create.php` insert | `edit.php` + `update.php` update | `delete.php` delete
- `config/dbconfig.php` PDO connection | `includes/` helpers + shared form | `css/style.css`
- Table `data_engineer_applications` has 13 columns (min. required: 8, incl. primary key + date_added).
