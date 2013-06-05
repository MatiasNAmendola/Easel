<?php

class HTTP_Response {

    const OK = '200 OK';
    const BAD_REQUEST = '400 Bad Request';
    const FORBIDDEN = '401 Forbidden';
    const NOT_FOUND = '404 Not Found';
    const SERVER_ERROR = '500 Server Error';

    protected $status = self::OK;

    protected $headers = array();

    protected $cookies = array();

    public $body = '';

    public function serve() {
        $this->sendHTTPStatus();
        foreach ($this->headers as $header => $value) {
            header("$header: $value");
        }
        foreach ($this->cookies as $cookie) {
            list($name, $value, $ttl) = $cookie;
            setcookie($name, $value, $ttl);
        }
        echo $this->body;
    }

    public function sendCookie($name, $value, $ttl=0) {
        $this->cookies[] = array($name, $value, $ttl);
    }

    public function generateUser() {
        $uaid = md5(rand());
        $this->sendCookie(User::COOKIE, $uaid);
        return new User($uaid);
    }

    public function setStatus($code) {
        $this->status = $code;
    }

    protected function sendHTTPStatus() {
        header("HTTP/1.1 {$this->status}");
    }
}
