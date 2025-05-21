<?php 

declare(strict_types=1);

/**
 * @author  : Jagepard <jagepard@yandex.ru>
 * @license https://mit-license.org/  MIT
 */

use Rudra\View\ViewFacade as View;

if (!function_exists('view')) {
    /**
     * Renders a template and returns the result as a string.
     *
     * @param string|array $path
     * @param array        $data
     * @return string
     */
    function view($path, array $data = []): string
    {
        return View::view($path, $data);
    }
}

if (!function_exists('render')) {
    /**
     * Renders and outputs a template directly.
     *
     * @param string|array $path
     * @param array        $data
     */
    function render($path, array $data = []): void
    {
        echo View::view($path, $data);
    }
}

if (!function_exists('cache')) {
    /**
     * Checks if a cached version is valid.
     *
     * @param array   $path
     * @param boolean $fullPage
     * @return string|null
     */
    function cache(array $path, $fullPage = false): ?string
    {
        return View::cache($path, $fullPage);
    }
}