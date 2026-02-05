<?php

namespace Mindtrack\Lib;

class SessionManager
{
    private $sessionName;

    public function __construct($sessionName = null)
    {
        if ($sessionName !== null) {
            $this->sessionName = $sessionName;
        } else {
            global $sessionName;
            $this->sessionName = $sessionName;
        }
    }

    public function set($data = null)
    {
        $_SESSION[$this->sessionName] = $data;
    }

    public function add($data = null)
    {
        if (is_array($data)) {
            $_SESSION[$this->sessionName] = array_merge($_SESSION[$this->sessionName] ?? [], $data);
        } else {
            $_SESSION[$this->sessionName][$data] = $data;
        }
    }

    public function get()
    {
        return $_SESSION[$this->sessionName] ?? null;
    }

    public function has()
    {
        return isset($_SESSION[$this->sessionName]);
    }

    public function remove($value = null)
    {
        if (!$this->has())
            return false;
        unset($_SESSION[$this->sessionName][$value]);
        return true;
    }

    public function destroy()
    {
        session_unset();
        session_destroy();
    }
}