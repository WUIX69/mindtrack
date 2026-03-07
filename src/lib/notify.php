<?php

namespace Mindtrack\Lib;

class Notify
{
    /**
     * Send a notification to a user or admin.
     */
    public function send()
    {
        return false;
    }

    /**
     * Get all notifications for the current user.
     *
     * @return array
     */
    public function all()
    {
        return []; // Not implemented
    }

    /**
     * Clear all notifications for the current user.
     */
    public function clear()
    {
        return false; // Not implemented
    }
}