<?php
// קובץ עזר להגדרת סיסמה - מחק אחרי השימוש
$password = 'saar0504040042';
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
echo "Hash: " . $hash . "\n";
file_put_contents(__DIR__ . '/admin_pass.php', "<?php return " . var_export($hash, true) . ";");
echo "Password updated!";
?>
