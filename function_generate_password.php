<?php

function excludeSpecialCharacters() {
    $excludeSpecialCheckbox = $_POST["excludeSpecial"];
    $specialCharactersInput = $_POST["specialCharacters"];
    if ($excludeSpecialCheckbox == "true") {
        return $specialCharactersInput;
    } else {
        return "";
    }
}

function generatePassword() {
    $length = $_POST["length"];
    $uppercaseIncluded = $_POST["uppercase"];
    $symbolsIncluded = $_POST["symbols"];
    $lowercaseIncluded = $_POST["lowercase"];
    $numbersIncluded = $_POST["numbers"];
    $excludeSpecialCharacters = $_POST["excludeSpecial"];
    $specialCharacters = excludeSpecialCharacters();
    $charset = "";
    if ($uppercaseIncluded) $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    if ($symbolsIncluded) $charset .= "!@#$%^&*()_+~`|}{[]:;?><,./-=";
    if ($lowercaseIncluded) $charset .= "abcdefghijklmnopqrstuvwxyz";
    if ($numbersIncluded) $charset .= "0123456789";
    if ($excludeSpecialCharacters) {
      $charset = str_replace(str_split($specialCharacters), '', $charset);
    }
    if ($charset === "") {
        return "Please select at least one option";
    }
    $password = "";
    for ($i = 0; $i < $length; $i++) {
      $randomIndex = rand(0, strlen($charset) - 1);
      $password .= $charset[$randomIndex];
    }
    return $password;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] == "generatePassword") {
            echo generatePassword();
        }
    }
}

?>

