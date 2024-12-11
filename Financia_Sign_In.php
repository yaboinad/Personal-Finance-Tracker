<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Financia_Sign_In_Images/financia logo.png">
    <link rel="stylesheet" href="Financia_Sign_In_Css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Financia - Sign In</title>
    <style>
        @media screen and (max-width: 1920px) and (max-height: 1080px) {
            body {
                background-image: url(Financia_Sign_In_Images/sign\ in\ background.png);
                background-repeat: no-repeat;
                background-color: rgb(199, 163, 245);
                background-size: 1920px 900px;
                width: 90vw;
            }
        }

        @font-face

        /*This will be served as font style for our website*/
            {
            font-family: Roboto1;
            src: url(Financia_Fonts/roboto/Roboto-Light.ttf);
        }

        @font-face

        /*This will be served as font style for our website*/
            {
            font-family: Roboto2;
            src: url(Financia_Fonts/roboto/Roboto-Bold.ttf);
        }

        @font-face

        /*This will be served as font style for our website*/
            {
            font-family: Roboto3;
            src: url(Financia_Fonts/roboto/Roboto-Black.ttf);
        }

        @font-face {
            font-family: Coolvetica1;
            src: url(Financia_Fonts/coolvetica/coolvetica\ condensed\ rg.otf);
        }

        @font-face {
            font-family: Coolvetica2;
            src: url(Financia_Fonts/coolvetica/coolvetica\ rg.otf);
        }
    </style>
</head>

<body>
    <table class="table1">
        <tr>
            <td class="Financia_box"><a class="Financia" href="Financia.php">Financia</a></td>
            <td style="width: 50vw;"></td>
            <td class="e-pay_box">
                <img class="e-pay_button" src="Financia_Home_Page_Images/plus.png" alt="" style="opacity: 0.5; cursor: not-allowed;">
            </td>
            <td class="notification_box"><img class="notification_button"
                    src="Financia_Home_Page_Images/Notification bell.png" alt=""></td>
            <td class="account_box">
                <img class="account" id="accountBtn" src="Financia_Home_Page_Images/Account profile.png" alt="">
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="Financia.php">Home</a>
                    <a href="Financia_Sign_Up.php">Sign Up</a>
                </div>
            </td>
            <td class="settings_box"><img class="settings_button" src="Financia_Home_Page_Images/Settings logo.png"
                    alt=""></td>
        </tr>
    </table>
    <table class="table2">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <form action="">
                <tr>
                    <td class="td_select">
                        <button class="select_nav" onclick="window.location.href='Financia_Dashboard_Overview.html'">Overview</button>
                    </td>
                    <td class="td_select">
                        <button class="select_nav" onclick="window.location.href='#'">Summary</button>
                    </td>
                    <td class="td_select">
                        <button class="select_nav" onclick="window.location.href='#'">History</button>
                    </td>
                    <td class="td_select">
                        <button class="select_nav" onclick="window.location.href='#'">Transactions</button>
                    </td>
                    <td class="td_select">
                        <button class="select_nav" onclick="window.location.href='#'">Reports</button>
                    </td>
                </tr>
            </form>
        <?php else: ?>
            <tr>
                <td class="td_select">
                    <button class="select_nav" disabled style="opacity: 0.5;">Overview</button>
                </td>
                <td class="td_select">
                    <button class="select_nav" disabled style="opacity: 0.5;">Summary</button>
                </td>
                <td class="td_select">
                    <button class="select_nav" disabled style="opacity: 0.5;">History</button>
                </td>
                <td class="td_select">
                    <button class="select_nav" disabled style="opacity: 0.5;">Transactions</button>
                </td>
                <td class="td_select">
                    <button class="select_nav" disabled style="opacity: 0.5;">Reports</button>
                </td>
            </tr>
        <?php endif; ?>
    </table>




    <table class="table3">
        <?php
        if (isset($_SESSION['reset_success'])) {
            echo "<div class='success-message'>";
            echo "<i class='fas fa-check-circle' style='margin-right: 10px;'></i>";
            echo $_SESSION['reset_success'];
            echo "</div>";
            unset($_SESSION['reset_success']);
        }
        if (isset($_SESSION['signup_success'])) {
            echo "<div class='success-message'>";
            echo "<i class='fas fa-check-circle' style='margin-right: 10px;'></i>";
            echo $_SESSION['signup_success'];
            echo "</div>";
            unset($_SESSION['signup_success']);
        }
        if (isset($_SESSION['login_error'])) {
            echo "<div class='error-message'>" . htmlspecialchars($_SESSION['login_error']) . "</div>";
            unset($_SESSION['login_error']);
        }
        ?>
        <form action="/Personal-Finance-Tracker/backend/process_login.php" method="POST">
            <tr>
                <td class="labelbox_table3">
                    <br><label class="label_table3" for="username">Email / Username</label>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="input-container">
                        <i class="fas fa-user"></i>
                        <input class="input_table3" type="text" name="username_email" placeholder="Username or Email" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="labelbox_table3">
                    <label class="label_table3" for="password">Password</label>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="input-container">
                        <i class="fas fa-lock"></i>
                        <input class="input_table3" type="password" name="password" placeholder="Password" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><br>
                    <hr style="border: 2px solid black; width: 100%; margin: 0 0 0 0;">
                </td>
            </tr>
            <tr>
                <td style="text-align: center; white-space: nowrap;">
                    <a class="new_user" href="Financia_Sign_Up.php">New User?</a>
                    <span class="link-divider">|</span>
                    <a class="forgot_password" href="Financia_Forgot_Password.php">Forgot Password?</a>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    <input class="log_in" type="submit" value="Log In" style="display: block; margin: 1vw auto;">
                </td>
            </tr>
        </form>
    </table>
    <br><br>
    <div>
        <hr style="margin: 12vw 0 0 -1vw; border: 0.1vw solid black; width: 39vw;">
        <hr style="width: 10vw; border: 0.1vw solid black; margin: -0.2vw 0 0 40vw;">
        <hr style="width: 3vw; border: 0.1vw solid black; margin: -0.2vw 0 0 53.5vw;">
        <hr style="width: 38.2vw; border: 0.1vw solid black; margin: -0.2vw 0 0 60vw;">
    </div>
    <div class="div6">
        <img class="social_media_logo" src="Financia_Home_Page_Images/facebook.png" alt="">
        <img class="social_media_logo" src="Financia_Home_Page_Images/twitter.png" alt="">
        <img class="social_media_logo" src="Financia_Home_Page_Images/tiktok.png" alt="">
        <img class="social_media_logo" src="Financia_Home_Page_Images/instagram.png" alt="">
    </div>
    <table class="table5">
        <tr>
            <td class="footer_link_box"><a class="footer_links" href="">About Us</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Terms & Conditions</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Privacy Policy</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Contact Us</a></td>
        </tr>
    </table>
    <br>
    <hr style="border: 0.1vw solid black; width: 99.2vw; margin: 0 -1vw 0 -1vw;">
    <p class="copyright">&copy; 2024 Financia. All Rights Reserved.</p>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accountBtn = document.getElementById('accountBtn');
            const dropdownMenu = document.getElementById('dropdownMenu');

            // Toggle the dropdown menu visibility
            accountBtn.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent event from bubbling up
                dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
            });

            // Close the dropdown if clicked outside
            window.addEventListener('click', function(event) {
                if (!accountBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.style.display = 'none';
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Password visibility toggle
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.querySelector('input[type="password"]');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle icon
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            // Clear input functionality
            const clearIcon = document.querySelector('.fa-times');
            const usernameInput = document.querySelector('input[name="username_email"]');

            clearIcon.addEventListener('click', function() {
                usernameInput.value = '';
                usernameInput.focus();
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const usernameInput = document.querySelector('input[name="username_email"]');
            const passwordInput = document.querySelector('input[name="password"]');

            usernameInput.addEventListener('input', function() {
                if (this.value.length < 3) {
                    this.classList.add('input-error');
                } else {
                    this.classList.remove('input-error');
                }
            });

            passwordInput.addEventListener('input', function() {
                if (this.value.length < 6) {
                    this.classList.add('input-error');
                } else {
                    this.classList.remove('input-error');
                }
            });
        });
    </script>
</body>

</html>