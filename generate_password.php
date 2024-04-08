<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Generator</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Password Generator
        <br>
        <span class="slogan-text"><strong>Click, Secure, Remember</strong></span>
        </h1>
        <div id="messageBox"></div>
        <input type="text" id="password" readonly placeholder="Click the button to generate a password">
        <button onclick="generatePassword()">Generate Password</button>
        <br>
        <p id="copyText" onclick="copyToClipboard()">Copy to Clipboard</p>
        <div class="customization-options">
            <h2>Customization Options:</h2>
            <div>
                <div id="status_password"></div>
            </div>
            <div>
                <label_length for="length">Password Length:</label_length>
                <input type="range" id="length" min="0" max="30" value="15">
                <span id="lengthValue">15</span>
            </div>
            <div>
                <input type="checkbox" id="symbols" checked>
                <label for="symbols">Symbols (!@#$)</label>
            </div>
            <div>
                <input type="checkbox" id="numbers" checked>
                <label for="numbers">Numbers (0123)</label>
            </div>
            <div>
                <input type="checkbox" id="lowercase" checked>
                <label for="lowercase">Lowercases (abcd)</label>
            </div>

            <div>
                <input type="checkbox" id="uppercase" checked>
                <label for="uppercase">Uppercases (ABCD)</label>
            </div>
            <div>
                <input type="checkbox" id="excludeSpecial" onclick="toggleSpecialCharacterField()">
                <label for="excludeSpecial">Exclude Characters</label>
            </div>
            <div id="specialCharactersField" style="display: none;">
                <input type="text" id="specialCharacters" placeholder="Type any characters to exclude...">
            </div>
        </div>
    </div>
    <footer>
        &copy; Team 7, All Rights Reserved
    </footer>
    <script>
        function excludeSpecialCharacters() {
            var excludeSpecialCheckbox = document.getElementById("excludeSpecial");
            var specialCharactersInput = document.getElementById("specialCharacters");

            if (excludeSpecialCheckbox.checked) {
                specialCharactersInput.disabled = false;
            } else {
                specialCharactersInput.disabled = true;
            }
        }

        function generatePassword() {
          document.getElementById("messageBox").style.display = "none";

            var length = document.getElementById("length").value;
            var uppercaseIncluded = document.getElementById("uppercase").checked;
            var symbolsIncluded = document.getElementById("symbols").checked;
            var lowercaseIncluded = document.getElementById("lowercase").checked;
            var numbersIncluded = document.getElementById("numbers").checked;
            var excludeSpecialCharacters = document.getElementById("excludeSpecial").checked;
            var specialCharacters = document.getElementById("specialCharacters").value;
            var charset = "";
            if (uppercaseIncluded) charset += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            if (symbolsIncluded) charset += "!@#$%^&*()_+~`|}{[]:;?><,./-=";
            if (lowercaseIncluded) charset += "abcdefghijklmnopqrstuvwxyz";
            if (numbersIncluded) charset += "0123456789";
            if (excludeSpecialCharacters) {
                charset = charset.replace(new RegExp("[" + specialCharacters + "]", "g"), "");
            }
            if (charset === "") {
                showMessage("Please select at least one option", false);
                return;
            }
            var password = "";
            for (var i = 0; i < length; i++) {
                var randomIndex = Math.floor(Math.random() * charset.length);
                password += charset[randomIndex];
            }
            document.getElementById("password").value = password;
        }

        function copyToClipboard() {
            var passwordInput = document.getElementById("password");
            var password = passwordInput.value;
            if (password.trim() === "") {
                showMessage("Password field is empty!", false);
                return;
            }
            passwordInput.select();
            try {
                document.execCommand("copy");
                showMessage("Successfully copied!", true);
            } catch (err) {
                showMessage("Unsuccessfully copied!", false);
            }
        }

        function showMessage(message, isSuccess) {
            var messageBox = document.getElementById("messageBox");
            messageBox.innerHTML = message;
            messageBox.className = isSuccess ? "success-message" : "failure-message";
            messageBox.style.display = "block";
            if (message !== "Please select at least one option" && message !== "Password field is empty!") {
                setTimeout(function() {
                    messageBox.style.display = "none";
                }, 1000);
            }
        }

        document.getElementById("length").addEventListener("input", function() {
            document.getElementById("lengthValue").textContent = this.value;
        });
        function updatePasswordStatus() {
            var strength = parseInt(document.getElementById("length").value);
            var statusPassword = document.getElementById("status_password");
            var statusText;

            if (strength >= 0 && strength < 5) {
                statusPassword.style.backgroundColor = "#ff6666";
                statusText = "Very Weak";
            } else if (strength >= 5 && strength < 10) {
                statusPassword.style.backgroundColor = "#ff9999";
                statusText = "Weak";
            } else if (strength >= 10 && strength < 20) {
                statusPassword.style.backgroundColor = "#8bca84";
                statusText = "Normal";
            } else if (strength >= 20 && strength < 25) {
                statusPassword.style.backgroundColor = "#88dc3d";
                statusText = "Strong";
            } else {
                statusPassword.style.backgroundColor = "#00b300";
                statusText = "Very Strong";
            }
            statusPassword.textContent = statusText;
        }
        updatePasswordStatus();

        document.getElementById("length").addEventListener("input", function() {
            document.getElementById("lengthValue").textContent = this.value;
            updatePasswordStatus();
        });

        function toggleSpecialCharacterField() {
            var specialCharactersField = document.getElementById("specialCharactersField");
            var excludeSpecialCheckbox = document.getElementById("excludeSpecial");

            if (excludeSpecialCheckbox.checked) {
                specialCharactersField.style.display = "block";
            } else {
                specialCharactersField.style.display = "none";
            }
        }
    </script>
</body>
</html>
