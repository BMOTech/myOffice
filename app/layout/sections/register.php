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
        <form id="registerForm" action="register.php"
              class="form-horizontal" method="post">
            <fieldset>

                <!-- Form Name -->
                <legend>Registrieren</legend>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="vorname">Vorname</label>
                    <div class="col-md-4">
                        <input id="vorname" name="vorname" type="text"
                               placeholder="Vorname"
                               class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nachname">Nachname</label>
                    <div class="col-md-4">
                        <input id="nachname" name="nachname" type="text"
                               placeholder="Nachname"
                               class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Multiple Radios -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="geschlecht">Geschlecht</label>
                    <div class="col-md-4">
                        <div class="radio">
                            <label for="geschlecht-0">
                                <input type="radio" name="geschlecht"
                                       id="geschlecht-0" value="m"
                                       checked="checked">
                                Männlich
                            </label>
                        </div>
                        <div class="radio">
                            <label for="geschlecht-1">
                                <input type="radio" name="geschlecht"
                                       id="geschlecht-1" value="w">
                                Weiblich
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label"
                           for="email">Email</label>
                    <div class="col-md-4">
                        <input id="email" name="email" type="text"
                               placeholder="Email"
                               class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Password input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="password">Passwort</label>
                    <div class="col-md-4">
                        <input id="password" name="password" type="password"
                               placeholder="Passwort"
                               class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Password input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="password2">Passwort
                        Wiederholung</label>
                    <div class="col-md-4">
                        <input id="password2" name="password2"
                               type="password" placeholder="Passwort"
                               class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-4 control-label"
                           for="land">Land</label>
                    <div class="col-md-4">
                        <select id="land" name="land" class="form-control">
                            <option value="DE">Deutschland</option>
                            <option value="EN">England</option>
                        </select>
                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="submit">Formular
                        absenden</label>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">
                            Registrieren
                        </button>
                    </div>
                </div>
                <hr/>
                <p>Bereits registriert? <a
                        href="/index.php">Login</a></p>
            </fieldset>
        </form>

    </div>
</div>