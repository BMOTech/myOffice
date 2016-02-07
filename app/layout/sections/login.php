<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <?php if (count($errors) > 0): ?>
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign"
                      aria-hidden="true"></span>
                <?php foreach ($errors as $err)
                echo $err ?>
            </div>
        <?php endif; ?>
        <form id="loginForm" action="index.php" method="post" class="form-horizontal">
            <fieldset>

                <!-- Form Name -->
                <legend>Login</legend>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="email">Email</label>
                    <div class="col-md-4">
                        <input id="email" name="email" type="text" placeholder="Email" autofocus="true" class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Password input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="password">Passwort</label>
                    <div class="col-md-4">
                        <input id="password" name="password" type="password" placeholder="Passwort" class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="submit">Login</label>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Login
                        </button>
                    </div>
                </div>
                <hr/>
                <p>Benötigen Sie einen Account? <a
                        href="/register.php">Registrieren</a></p>
            </fieldset>
        </form>

    </div>
</div>