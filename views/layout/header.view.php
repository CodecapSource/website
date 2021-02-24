<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codecap Organiser</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;0,900;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?=URL?>/assets/css/main.css">

    <script src="https://kit.fontawesome.com/af845f7d3f.js" crossorigin="anonymous"></script>

</head>
<body>

<div class="organiser">
    <div class="organiser-left">
        <div class="organiser-left-content">

            <a href="<?=URL?>/organiser/dashboard.php" class="organiser-left-logo">
                <img src="<?=URL?>/assets/images/logo-light.svg" alt="Codecap">
            </a>
        
            <div class="organiser-left-header">
                <div class="header-stats">
                    <div class="header-stats-icon"></div>
                    <div class="header-stats-text">
                        <h5>Available <span class="green-text">Codn</span></h5>
                        <div class="header-stats-text-row">
                            <h3><?=$user['or_balance']?></h3>
                            <div class="header-stats-text-row-button">
                                <a href="<?=URL?>/organiser/deposit.php" class="button button-green">Add More</a>
                                <a href="<?=URL?>/organiser/withdraw.php" class="button button-golden">Withdraw</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="organiser-left-nav">
                <li><a href="<?=URL?>/organiser/dashboard.php">Dashboard</a></li>
                <li><h3>Events</h3></li>
                <li><a href="<?=URL?>/organiser/add_event.php">Add Event</a></li>
                <li><a href="<?=URL?>/organiser/events.php">View Events</a></li>
                <li><h3>Transactions</h3></li>
                <li><a href="<?=URL?>/organiser/transactions.php?d">Deposits</a></li>
                <li><a href="<?=URL?>/organiser/transactions.php?w">Withdrawals</a></li>
                <li><a href="<?=URL?>/organiser/transactions.php?e">Events</a></li>
                <li><a href="<?=URL?>/organiser/transactions.php">All Transactions</a></li>
                <li><h3>Misc.</h3></li>
                <li><a href="<?=URL?>/organiser/settings.php">Settings</a></li>
                <li><a href="<?=URL?>/organiser/logout.php">Logout</a></li>
            </ul>

        </div>
    </div>
    <div class="organiser-right">
        <header class="mheader">
            <div class="mheader-inner">
                <nav class="mheader-nav">
                    <ul class="mheader-nav-items">
                        <li><a href="<?=URL?>/organiser/events.php">Events</a></li>
                        <li><a href="<?=URL?>/organiser/transactions.php">Transactions</a></li>
                    </ul>
                </nav>
                
                <div class="mheader-end">
                    <div class="mheader-end-link"><a href="<?=URL?>/contact.php">Contact Us</a></div>
                    <a href="<?=URL?>/organiser/settings.php" class="mheader-end-profile">
                        <div class="mheader-end-profile-text">
                            <p>Session logged</p>
                            <h3><?=$user['or_name']?></h3>
                        </div>
                        <div class="mheader-end-profile-avatar">
                            <img src="<?=URL?>/assets/images/avatar.png" alt="Avatar">
                        </div>
                    </a>
                </div>
            </div>
        </header>

        <div class="organiser-right-content">

        