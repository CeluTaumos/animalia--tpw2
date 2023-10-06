<?php

class Render {

    private $headerPath;
    private $footerPath;

    public function __construct($headerPath, $footerPath) {
        $this->headerPath = $headerPath;
        $this->footerPath = $footerPath;
    }

    public function render($contenido, $datos = null) {
        include_once($this->headerPath);
        include_once("view/" . $contenido);
        include_once($this->footerPath);
    }
}