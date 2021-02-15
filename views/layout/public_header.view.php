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
