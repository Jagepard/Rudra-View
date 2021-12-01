<?php

if (!function_exists('view')) {
    /**
     * @param       $path
     * @param array $data
     */
    function view($path, array $data = [])
    {
        \Rudra\View\ViewFacade::view($path, $data);
    }
}
