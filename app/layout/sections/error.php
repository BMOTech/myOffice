<?php if (count($errors) > 0): ?>
    <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign"
                      aria-hidden="true"></span> <strong>Fehler:</strong>
        <ul>
            <?php
            foreach ($errors as $error) {
                echo "<li>".$error."</li>\n";
            } ?>
        </ul>
    </div>
<?php endif; ?>