<?php

namespace Mindtrack\Lib;

class SessionManager
{
    private $sessionKey;

    public function __construct($sessionKey)
    {
        $this->sessionKey = $sessionKey;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set($data)
    {
        $_SESSION[$this->sessionKey] = $data;
    }

    public function update($data)
    {
        if (is_array($data)) {
            $_SESSION[$this->sessionKey] = array_merge($this->all(), $data);
        }
    }

    public function all()
    {
        return $_SESSION[$this->sessionKey] ?? [];
    }

    public function get($key = null)
    {
        $data = $this->all();
        if ($key === null)
            return $data;
        return $data[$key] ?? null;
    }

    public function has()
    {
        return !empty($this->all());
    }

    public function remove($key)
    {
        if (isset($_SESSION[$this->sessionKey][$key])) {
            unset($_SESSION[$this->sessionKey][$key]);
            return true;
        }
        return false;
    }

    public function destroy()
    {
        $_SESSION[$this->sessionKey] = [];
        unset($_SESSION[$this->sessionKey]);
    }
}