<?php

use Rudra\View\ViewFacade as View;

if (!function_exists('view')) {
    /**
     * @param       $path
     * @param array $data
     * @return string
     */
    function view($path, array $data = [])
    {
        return View::view($path, $data);
    }
}
