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
                    als <?php echo $_SESSION['user'] ?></p>
                <li><a href="intern.php?action=logout">Logout</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container">
    <div id='content'>
        <p>Zuletzt eingeloggt am: <?php echo $_SESSION['lastLogin'] ?></p>
    </div>
</div>