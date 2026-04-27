<?php
echo "<h1>PHP Works!</h1>";
echo "<p>PHP version: " . phpversion() . "</p>";
echo "<p>Current dir: " . __DIR__ . "</p>";
echo "<p>Files here: <pre>";
print_r(glob(__DIR__ . '/*'));
echo "</pre></p>";

echo "<h2>includes/ folder:</h2><pre>";
print_r(glob(__DIR__ . '/includes/*'));
echo "</pre>";

echo "<h2>Test require:</h2>";
if (file_exists(__DIR__ . '/includes/functions.php')) {
    echo "functions.php EXISTS";
} else {
    echo "functions.php NOT FOUND";
}
