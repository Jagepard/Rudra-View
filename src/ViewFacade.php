<?php

declare(strict_types=1);

/**
 * @author  : Jagepard <jagepard@yandex.ru>
 * @license https://mit-license.org/  MIT
 */

namespace Rudra\View;

use Rudra\Container\Traits\FacadeTrait;

/**
 * @method static void setup(string $viewPath, string $prefix = '', string $extension = 'phtml')
 * @method static string|false view($path, array $data = [])
 * @method static cache(array $path, $fullPage = false)
 *
 * @see View
 */
final class ViewFacade
{
    use FacadeTrait;

    /**
     * Renders and outputs a template directly to the output buffer.
     * 
     * This method delegates the rendering logic to the `view` method and outputs the result directly.
     * It supports both single paths and arrays for specifying the template to render.
     * 
     * @param string|array $path The template path or an array containing:
     *                           - The primary template path to render.
     *                           - (Optional) A cache key for storing the rendered output.
     * @param array        $data An associative array of data to be passed to the template for rendering.
     * 
     * @return void
     */
    public static function render($path, array $data = []): void
    {
        echo self::view($path, $data);
    }
}
