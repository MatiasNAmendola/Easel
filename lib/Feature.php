<?php

class Feature {

    const ON = 'on';

    static $instance = null;

    private $user = null;

    private $cache = array();

    private $config = null;

    protected static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new Feature();
        }
        return self::$instance;
    }

    private function getConfig() {
        if (is_null($this->config)) {
            if (defined('CONFIG') && file_exists(CONFIG)) {
                $server_config = array();
                include CONFIG;
                $this->config = $server_config;
            }
        }
        return $this->config;
    }

    private function _setUser(User $user) {
        $this->user = $user;
    }

    private function _isEnabled($flag) {
        return $this->_isEnabledFor($flag, $this->user);
    }

    private function _isEnabledFor($flag, User $user) {
        if (empty($this->cache[$user->uaid])) {
            $this->cache[$user->uaid] = [];
        }
        if (empty($this->cache[$user->uaid][$flag])) {
            $this->cache[$user->uaid][$flag] = $this->calculateFlag($this->getConfig(), explode('.', $flag), $user);
        }
        return $this->cache[$user->uaid][$flag];
    }

    private function calculateFlag($config, $flags, User $user) {
        $flag = array_shift($flags);
        if (empty($config[$flag])) {
            return false;
        }
        if (!empty($flags)) {
            return $this->calculateFlag($config, $flags, $user);
        }
        $criteria = $config[$flag];
        return $this->assertCriteria($criteria, $flag, $user);
    }

    private function assertCriteria($criteria, $flag, $user) {
        if (is_string($criteria)) {
            if ($criteria == self::ON) {
                return true;
            }
            return false;
        }
        if (is_bool($criteria)) {
            return $criteria;
        }
        if (is_int($criteria)) {
            if ($criteria <= 0) {
                return false;
            }
            if ($criteria >= 100) {
                return true;
            }
            // Make a hash of this uaid + the flag
            $hash = md5($user->uaid.'|'.$flag);
            $hash = substr($hash, '0', '4');
            $hash_number = hexdec($hash) % 100;
            if ($hash_number < $criteria) {
                return true;
            }
            return false;
        }
        return true;

    }

    public static function setUser(User $user) {
        return self::getInstance()->_setUser($user);
    }

    public static function isEnabled($flag) {
        return self::getInstance()->_isEnabled($flag);
    }

    public static function isEnabledFor($flag, User $user) {
        return self::getInstance()->_isEnabledFor($flag, $user);
    }
}
