<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                myOffice
            </a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="#overview"><i class="fa fa-home"></i>&nbsp; Übersicht</a></li>
                <li><a href="#notes"><i class="fa fa-sticky-note"></i>&nbsp; Notizen</a></li>
                <li><a href="#contacts"><i class="fa fa-user"></i>&nbsp; Kontakte</a></li>
                <li><a href="#tasks"><i class="fa fa-book"></i>&nbsp; Aufgaben</a></li>
                <li><a href="#calendar"><i class="fa fa-calendar"></i>&nbsp; Kalender</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Eingeloggt als <?php echo $_SESSION['user'] ?>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="intern.php?action=logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div id="error_container" class="alert alert-danger hidden" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> <strong>Fehler:</strong>
        <ul id="errors"></ul>
    </div>

    <div id='content'></div>
</div>