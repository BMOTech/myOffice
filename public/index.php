<!DOCTYPE html>
<html lang="de" ng-app="app">
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
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="../" class="navbar-brand">Webtechniken</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li><a>Aufgaben</a></li>
                <li><a>Kalender</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="http://builtwithbootstrap.com/" target="_blank">Built With Bootstrap</a></li>
                <li><a href="https://wrapbootstrap.com/?ref=bsw" target="_blank">WrapBootstrap</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container">
    <div class="todo-wrapper" ng-controller="TodoCtrl">
        <h2>You've got <span class="emphasis">{{getTotalTodos()}}</span> things to do</h2>
        <ul>
            <li ng-repeat="todo in todos">
                <input type="checkbox" ng-model="todo.done"/>
                <span class="done-{{todo.done}}">{{todo.text}}</span>
            </li>
        </ul>
        <form>
            <input class="add-input" placeholder="I need to..." type="text" ng-model="formTodoText" ng-model-instant />
            <button class="add-btn" ng-click="addTodo()"><h2>Add</h2></button>
        </form>

        <button class="clear-btn" ng-click="clearCompleted()">Clear completed</button>
    </div>

</div>


<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bundle.js"></script>
<script src="js/main.js"></script>
</body>
</html>