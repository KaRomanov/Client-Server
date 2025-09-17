<?php
function validateEmail($a) {
    if (!empty($a) && filter_var($a, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

function validateUsername($a) {
    if (empty($a) || strlen($a) < 6) {
        return false;
    }
    return true;
}

function validatePassword($a) {
    if (empty($a) || strlen($a) < 8) {
        return false;
    }
    return true;
}
?>