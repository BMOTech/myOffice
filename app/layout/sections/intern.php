<div class="navbar navbar-default nav-links navbar-fixed-top navbar-custom">
    <div class="container">
        <a class="mini-navbar navbar-brand" href="/">
            myOffice
        </a>
        <ul class="nav navbar-nav">
            <li><a><i class="fa fa-home"></i>&nbsp; Übersicht</a></li>
            <li><a><i class="fa fa-sticky-note"></i>&nbsp; Notizen</a></li>
            <li><a><i class="fa fa-user"></i>&nbsp; Kontakte</a></li>
            <li><a><i class="fa fa-book"></i>&nbsp; Aufgaben</a></li>
            <li><a id="link_calendar" href="#"><i class="fa fa-calendar"></i>&nbsp; Kalender</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle"
                   data-toggle="dropdown">Eingeloggt als <?php echo $_SESSION['user'] ?>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="intern.php?action=logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>




<div class="container">
    <div id='content'>
        <p>Zuletzt eingeloggt am: <?php echo $_SESSION['lastLogin'] ?></p>
    </div>
</div>