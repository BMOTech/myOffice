<?php

function exception_handler($exception) {
    echo $exception->getMessage(), "\n";
}

set_exception_handler('exception_handler');

?>