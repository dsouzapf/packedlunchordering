<?php
include_once("session_init.php");
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Change Password - Packed Lunch Ordering</title>
        <link rel="stylesheet" href="stylesheet.css">
    </head>

    <body>

        <button onclick="window.location.href='index.php'">Home</button>

        <div id="changePasswordFailedDiv">

            <?php
            if (isset($_SESSION["changePasswordFailedReason"])) {

                print("<p>Failed to change password:<br>" . $_SESSION["changePasswordFailedReason"] . "</p>");
                unset($_SESSION["changePasswordFailedReason"]);

            }
            ?>

        </div>

        <form action="changePasswordRun.php" method="POST">

            Current Password: <input type="password" name="currentPasswordAttempt"><br>

            New Password: <input type="password" name="newPassword" id="changePasswordNewPasswordInput"><br>
            Repeat Password: <input type="password" name="newPasswordConfirm" id="changePasswordNewPasswordConfirmInput"><br>
            <p id="changePasswordNewPasswordErrorP"></p>

            <input type="submit">

        </form>

    </body>

    <script>

    var errorP = document.getElementById("changePasswordNewPasswordErrorP");
    var newPasswordInput = document.getElementById("changePasswordNewPasswordInput");
    var newPasswordConfirmInput = document.getElementById("changePasswordNewPasswordConfirmInput");

    function refreshErrorP() {

        var match = newPasswordInput.value == newPasswordConfirmInput.value;
        console.log(match);

        if (match) {

            errorP.innerText = "";

        }
        else {

            errorP.innerText = "Passwords do not match!";

        }

    }

    newPasswordInput.addEventListener("keyup", refreshErrorP);
    newPasswordConfirmInput.addEventListener("keyup", refreshErrorP);

    </script>

</html>