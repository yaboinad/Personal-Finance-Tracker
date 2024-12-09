<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Financia</title>
    <link rel="stylesheet" href="Financia CSS/Financia_Forgot_Password.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>

@media screen and (max-width: 1920px) and (max-height: 1080px) {
            body {
                background: url(Financia_Sign_Up_Images/sign\ in\ background.png) no-repeat scroll;
                background-color: rgb(199, 163, 245);
                background-size: 1920px 890px;
                width: 90vw;
            }
        }
        @font-face {
            font-family: Roboto1;
            src: url(Financia_Fonts/roboto/Roboto-Light.ttf);
        }

        @font-face {
            font-family: Roboto2;
            src: url(Financia_Fonts/roboto/Roboto-Bold.ttf);
        }

        @font-face {
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

    <?php
    if (isset($_SESSION['reset_success'])) {
        echo "<div class='success-message'>" . $_SESSION['reset_success'] . "</div>";
        unset($_SESSION['reset_success']);
    }
    ?>

    <!-- Navigation Menu -->
    <table class="table2">
        <form action="">
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
        </form>
    </table>

    <!-- Main Content Section -->
    <div class="forgot-password-container">
        <div class="form-box">
            <form action="backend/reset_password.php" method="POST">
                <?php
                    session_start();
                    if (isset($_SESSION['reset_errors'])) {
                        foreach ($_SESSION['reset_errors'] as $error) {
                            echo "<p style='color: red; text-align: center;'>$error</p>";
                        }
                        unset($_SESSION['reset_errors']);
                    }
                ?>
                <div class="input-row">
                    <div class="input-group">
                        <label for="email">Email / Username</label>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" id="email" name="email" required>
                            <i class="fas fa-times clear-icon"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="mobile">Mobile Number</label>
                        <div class="input-field">
                            <div class="mobile-container">
                                <div class="prefix-box">+63</div>
                                <input type="number" 
                                    id="mobile" 
                                    name="mobile" 
                                    maxlength="11" 
                                    class="mobile-input"
                                    required>
                            </div>
                            <i class="fas fa-times clear-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="input-row">
                    <div class="input-group">
                        <label for="new_password">New Password</label>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="new_password" name="new_password" required>
                            <i class="fas fa-eye toggle-password"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                            <i class="fas fa-eye toggle-password"></i>
                        </div>
                    </div>
                </div>

                <hr class="divider">

                <div class="links-container">
                    <a href="Financia_Sign_Up.php" class="link">New User?</a>
                    <span class="link-divider">|</span>
                    <a href="Financia_Sign_In.php" class="link">Already have an account?</a>
                </div>

                <button type="submit" class="submit-btn">Log In</button>
            </form>
        </div>
    </div>

    <!-- Footer Section -->
    <div>
        <hr style="margin: 12vw 0 0 -1vw; border: 0.1vw solid black; width: 38vw;">
        <hr style="width: 9vw; border: 0.1vw solid black; margin: -0.2vw 0 0 40vw;">
        <hr style="width: 3vw; border: 0.1vw solid black; margin: -0.2vw 0 0 52vw;">
        <hr style="width: 39.2vw; border: 0.1vw solid black; margin: -0.2vw 0 0 58vw;">
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
            <td class="footer_link_box"><a class="footer_links" href="">Market Insights</a></td>
        </tr>
        <tr>
            <td class="footer_link_box"><a class="footer_links" href="">User Support</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Privacy Policy</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Budget Planner</a></td>
        </tr>
        <tr>
            <td class="footer_link_box"><a class="footer_links" href="">Contact Us</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Security Information</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Savings Tracker</a></td>
        </tr>
    </table>
    <br>
    <hr style="border: 0.1vw solid black; width: 99.2vw; margin: 0 -1vw 0 -1vw;">
    <p class="copyright">&copy; 2024 Financia. All Rights Reserved.</p>

    <script>
        // Account Dropdown
        const accountBtn = document.getElementById('accountBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');

        accountBtn.addEventListener('click', (event) => {
            event.stopPropagation();
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', (event) => {
            if (!accountBtn.contains(event.target)) {
                dropdownMenu.style.display = 'none';
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const mobileInput = document.getElementById('mobile');
            
            mobileInput.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                if (value.length > 0 && !value.startsWith('09')) {
                    value = '09' + value;
                }
                if (value.length > 11) {
                    value = value.substring(0, 11);
                }
                this.value = value;
            });

            mobileInput.addEventListener('blur', function() {
                if (!this.value || this.value === '09') {
                    this.value = '';
                }
            });

            mobileInput.addEventListener('focus', function() {
                if (!this.value) {
                    this.value = '09';
                }
            });
        });

        // Password visibility toggle
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });

        // Clear input functionality
        document.querySelectorAll('.clear-icon').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                input.value = '';
                input.focus();
            });
        });
    </script>
</body>

</html>
