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

    public static function render($path, array $data = []): void
    {
        echo self::view($path, $data);
    }
}
