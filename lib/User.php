<?php

class User {

    const COOKIE = '_site_uaid';

    public function __construct($uaid) {
        $this->uaid = $uaid;
    }
}
