<?php
// זה קובץ עזר חד-פעמי לשינוי הסיסמה
// מחק את הקובץ לאחר השימוש

$password = 'saar0504040042';
$hash = password_hash($password, PASSWORD_BCRYPT);
$php = '<?php return ' . var_export($hash, true) . ';';

if (file_put_contents(__DIR__ . '/admin_pass.php', $php)) {
    echo 'סיסמה עודכנה בהצלחה!<br>';
    echo 'עכשיו מחק את הקובץ הזה (setup-password.php)';
} else {
    echo 'שגיאה בשמירה';
}
?>
