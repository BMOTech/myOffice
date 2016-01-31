<?php
use Office\User\User;

require_once(__DIR__.'/User/Auth.php');
require_once(__DIR__.'/User/User.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        switch ($action) {
            case 'logout':
                User::logout();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Webtechniken</title>

    <link href="css/style.css" rel="stylesheet">
    <link href="css/fullcalendar.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script
        src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="../" class="navbar-brand">Webtechniken</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse"
                    data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li><a>Aufgaben</a></li>
                <li><a id="link_calendar" href="#">Kalender</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <p class="navbar-text">Eingeloggt
                    als <?php echo $_SESSION['user']['email'] ?></p>
                <li><a href="intern.php?action=logout">Logout</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container">
    <div id='content'>
        <h1>Home</h1>
        <p>This is the home page.</p>
        <ul>
            <li>I'm a list item!</li>
            <li>Me too!</li>
        </ul>
    </div>
</div>
<button id="#test" type="submit">test</button>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<!--  <script src="js/libraries.js"></script> -->
<script src="js/main.js"></script>
</body>
</html>