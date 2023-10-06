<?php

class Redirect {
    public static function to($path) {
        header("location:$path");
        exit();
    }

    public static function root() {
        header("location:/");
        exit();
    }
}