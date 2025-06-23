<?php 

declare(strict_types=1);

/**
 * @author  : Jagepard <jagepard@yandex.ru>
 * @license https://mit-license.org/  MIT
 */

use Rudra\View\ViewFacade as View;

if (!function_exists('view')) {
    function view(string|array $path, array $data = []): string
    {
        return View::view($path, $data);
    }
}

if (!function_exists('render')) {
    function render(string|array $path, array $data = []): void
    {
        echo View::view($path, $data);
    }
}

if (!function_exists('cache')) {
    function cache(array $path, bool $fullPage = false): ?string
    {
        return View::cache($path, $fullPage);
    }
}
