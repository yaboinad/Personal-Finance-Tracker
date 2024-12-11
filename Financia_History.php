<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Financia CSS/Financia_History.css">
    <title>Financia - History</title>
    <style>
        @media screen and (max-width: 1920px) and (max-height: 1080px) {
            body {
                background-image: url(Financia_Dashboard_Overview_Images/Dashboard\ Overview\ Background.png);
                background-color: rgb(199, 163, 245);
                background-repeat: no-repeat;
                background-position-y: top;
                background-size: 1920px 800px;
                width: 95vw;
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
            <td class="Financia_box"><a class="Financia" href="Financia.html">Financia</a></td>
            <td style="width: 50vw;"></td>
            <td class="e-pay_box">
                <img class="e-pay_button" id="epayBtn" src="Financia_Home_Page_Images/plus.png" alt="">
                <div class="dropdown-menu" id="dropdownMenuEpay">
                    <a href="Financia-E-Pay.html">E-Pay</a>
                </div>
            </td>

            <td class="notification_box"><img class="notification_button"
                    src="Financia_Home_Page_Images/Notification bell.png" alt=""></td>
            <td class="account_box">
                <img class="account" id="accountBtn" src="Financia_Home_Page_Images/Account profile.png" alt="">
                <div class="dropdown-menu" id="dropdownMenuAccount">
                    <a href="Financia_Sign_In.html">Sign In</a>
                    <a href="Financia_Sign_Up.php">Sign Up</a>
                    <a href="#">Account</a>

                </div>
            </td>
            <td class="settings_box"><img class="settings_button" src="Financia_Home_Page_Images/Settings logo.png"
                    alt=""></td>
        </tr>
    </table>
    <table class="table2">
        <form action="">
            <tr>
                <td class="td_link">
                    <a class="nav_link" href="Financia_Dashboard_Overview.html">Overview</a>
                </td>
                <td class="td_link">
                    <a class="nav_link" href="Financia_Dashboard_Summary.html">Summary</a>
                </td>
                <td class="td_link">
                    <a class="nav_link" href="Financia_History.html">History</a>
                </td>
                <td class="td_link">
                    <a class="nav_link" href="Financia_Transactions.html">Transactions</a>
                </td>
                <td class="td_link">
                    <a class="nav_link" href="#">Reports</a>
                </td>
            </tr>
        </form>
    </table>

    <div class="activity-title">
        <h1>Activity Log</h1>
    </div>
    <div class="activity-container">
        <div class="filter-bar">
            <select>
                <option>Sort by</option>
            </select>
            <button>✔</button>
            <button>✖</button>
            <input type="text" class="search-bar" placeholder="Search" />
        </div>
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Activity Name</th>
                    <th>Category</th>
                    <th>Date & Time</th>
                    <th>More Info</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Grocery Shopping</td>
                    <td>Expense</td>
                    <td>2024-11-10 14:30</td>
                    <td>View</td>
                </tr>
                <tr>
                    <td>Salary Payment</td>
                    <td>Income</td>
                    <td>2024-11-01 09:00</td>
                    <td>View</td>
                </tr>
                <tr>
                    <td>Gym Membership</td>
                    <td>Expense</td>
                    <td>2024-11-05 18:00</td>
                    <td>View</td>
                </tr>
                <tr>
                    <td>Freelance Project</td>
                    <td>Income</td>
                    <td>2024-11-07 15:45</td>
                    <td>View</td>
                </tr>
                <tr>
                    <td>Dinner with Friends</td>
                    <td>Expense</td>
                    <td>2024-11-09 20:15</td>
                    <td>View</td>
                </tr>
            </tbody>
        </table>
    </div>

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
            <td class="footer_link_box"><a class="footer_links" href="">Privacy Policy</a></td>
            <td class="footer_link_box"><a class="footer_links" href="">Contact Us</a></td>
        </tr>
    </table>
    <br>
    <hr style="border: 0.1vw solid black; width: 99.2vw; margin: 0 -1vw 0 -1vw;">
    <p class="copyright">&copy; 2024 Financia. All Rights Reserved.</p>

    <script>
        // E-Pay Dropdown
        const epayBtn = document.getElementById('epayBtn');
        const dropdownMenuEpay = document.getElementById('dropdownMenuEpay');

        // Account Dropdown
        const accountBtn = document.getElementById('accountBtn');
        const dropdownMenuAccount = document.getElementById('dropdownMenuAccount');

        // Toggle visibility of E-Pay dropdown
        epayBtn.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent click from bubbling up
            dropdownMenuEpay.style.display =
                dropdownMenuEpay.style.display === 'block' ? 'none' : 'block';
            dropdownMenuAccount.style.display = 'none'; // Close other dropdown
        });

        // Toggle visibility of Account dropdown
        accountBtn.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent click from bubbling up
            dropdownMenuAccount.style.display =
                dropdownMenuAccount.style.display === 'block' ? 'none' : 'block';
            dropdownMenuEpay.style.display = 'none'; // Close other dropdown
        });

        // Close dropdowns when clicking outside
        window.addEventListener('click', () => {
            dropdownMenuEpay.style.display = 'none';
            dropdownMenuAccount.style.display = 'none';
        });
    </script>
</body>

</html>