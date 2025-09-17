<!DOCTYPE html>
<html lang="bg">
<?php
require_once "../Classes/validateFunctions.php";


$tests = [];

function assertEquals($actual, $expected, $message) {
    global $tests;
    if ($actual === $expected) {
        $tests[] = "PASS: $message";
    } else {
        $tests[] = "FAIL: $message (expected " . var_export($expected, true) . ", got " . var_export($actual, true) . ")";
    }
}


assertEquals(validateEmail("test@example.com"), true, "valid email");
assertEquals(validateEmail("bademail.com"), false, "missing @");
assertEquals(validateEmail("badem@ailcom"), false, "missing top level domain");
assertEquals(validateEmail(""), false, "empty email");


assertEquals(validateUsername("abcdef"), true, "valid username");
assertEquals(validateUsername("abc"), false, "too short username");
assertEquals(validateUsername(""), false, "empty username");


assertEquals(validatePassword("mypassword"), true, "valid password");
assertEquals(validatePassword(""), false, "empty password");
assertEquals(validatePassword("short1"), false, "short password");
?>

<div>
<?php
echo "Test Results:<br><br>";
echo "<ul>";
foreach ($tests as $result) {
    echo "<li>$result</li>";
}
echo "</ul>";
?>
</div>

</html>