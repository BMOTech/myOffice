<?php
namespace App\Layout;

Class Layout
{
    public function show($view, $errors, $data)
    {
        $title = SITE_NAME.' - '.$data['title'];

        include APP.'layout/sections/Header.php';
        include APP.'layout/sections/'.$view.'.php';
        include APP.'layout/sections/Footer.php';

    }

}

?>