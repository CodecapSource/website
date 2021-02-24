<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codecap</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;0,900;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?=URL?>/assets/css/main.css">

    <script src="https://kit.fontawesome.com/af845f7d3f.js" crossorigin="anonymous"></script>

</head>
<body>

<?php if (!isset($header)): ?>
<header class="pheader">
    <div class="pheader-inner">
        
        <a href="<?=URL?>" class="pheader-logo">
            <img src="<?=URL?>/assets/images/logo-dark.svg" alt="Codecap">
        </a>

        <nav class="pheader-nav">
            <ul class="pheader-nav-items">
                <li><a href="<?=URL?>/competitions.php">Competitions</a></li>
                <li class="pheader-nav-items-double">
                    <div class="items-double-span">benefits of choosing <div class="codecap-light-icon"></div></div>
                    <a href="#"><span>For</span> Programmers</a>
                    <a href="#"><span>For</span> Organisers</a>
                </li>
                <li><a href="<?=URL?>/contact.php">Contact Us</a></li>
                <li><a href="<?=URL?>/organiser/" class="link-organise">Organise</a></li>
                <li><a href="<?=URL?>/launchpad/" class="link-launch">Launch</a></li>
            </ul>
        </nav>
        
    </div>
</header>
<?php endif; ?>

<?php if(isset($member_header)): ?>
<header class="mheader">
    <div class="mheader-inner">
        
        <a href="<?=URL?>" class="mheader-logo">
            <img src="<?=URL?>/assets/images/logo-light.svg" alt="Codecap">
        </a>

        <nav class="mheader-nav">
            <ul class="mheader-nav-items">
                <li><a href="<?=URL?>/competitions.php">Competitions</a></li>
                <li><a href="<?=URL?>/launchpad/participations.php">Participations</a></li>
                <li><a href="<?=URL?>/launchpad/transactions.php">Transactions</a></li>
            </ul>
        </nav>
        
        <div class="mheader-end">
            <div class="mheader-end-link"><a href="<?=URL?>/contact.php">Contact Us</a></div>
            <a href="<?=URL?>/launchpad/dashboard.php" class="mheader-end-profile">
                <div class="mheader-end-profile-text">
                    <p>Session logged</p>
                    <h3><?=$user['member_name']?></h3>
                </div>
                <div class="mheader-end-profile-avatar">
                    <img src="<?=URL?>/assets/images/avatar.png" alt="Avatar">
                </div>
            </a>
        </div>
    </div>
    <div class="mheader-bottom">
        <div class="mheader-bottom-inner">
            <div class="mheader-bottom-left">
                <div class="header-stats">
                    <div class="header-stats-icon"></div>
                    <div class="header-stats-text">
                        <h5>Available <span class="green-text">Codn</span></h5>
                        <div class="header-stats-text-row">
                            <h3><?=$user['member_balance']?></h3>
                            <div class="header-stats-text-row-button">
                                <a href="<?=URL?>/launchpad/deposit.php" class="button button-green">Add More</a>
                                <a href="<?=URL?>/launchpad/withdraw.php" class="button button-golden">Withdraw</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mheader-bottom-right">
                <a href="<?=URL?>/launchpad/logout.php">Logout</a>
            </div>
        </div>
    </div>
</header>
<?php endif; ?>
