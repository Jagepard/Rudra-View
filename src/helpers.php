<?php

use Rudra\View\ViewFacade as View;

if (!function_exists('view')) {
    /**
     * @param       $path
     * @param array $data
     * @return string
     */
    function view($path, array $data = []): string
    {
        return View::view($path, $data);
    }
}

if (!function_exists('render')) {
    /**
     * @param       $path
     * @param array $data
     * @return string
     */
    function render($path, array $data = [])
    {
        return View::render($path, $data);
    }
}

if (!function_exists('cache')) {
    /**
     * @param array $path
     * @param false $fullPage
     * @return mixed
     */
    function cache(array $path, $fullPage = false)
    {
        return View::cache($path, $fullPage);
    }
}
