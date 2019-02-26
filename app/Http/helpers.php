<?php

if (! function_exists('auth_user')) {
    /**
     * Auth user.
     * 
     * Get auth user.
     * 
     * @param string|null  $guard
     */
    function auth_user($guard = 'web')
    {
        return auth()->guard($guard)->user();
    }
}
