<?php
        //Logout
        session_start();
        if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["logout"]))
        {
            session_unset();
            session_destroy();
        }