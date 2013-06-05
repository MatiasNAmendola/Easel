<?php

abstract class TemplateEngine {

    protected $opts;
    protected $vars;

    public function __construct($opts) {
        $this->opts = $opts;
    }

    public abstract function render($tpl, $vars);
}
