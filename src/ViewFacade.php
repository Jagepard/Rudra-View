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
 * @method static string|false view(string|array $path, array $data = [])
 * @method static ?string cache(array $path, bool $fullPage = false)
 *
 * @see View
 */
final class ViewFacade
{
    use FacadeTrait;

    /**
     * Renders the template at the specified path and outputs the result to the screen.
     * --------------------
     * Рендерит шаблон по указанному пути и выводит результат на экран.
     *
     * @param string|array $path
     * @param array $data
     * @return void
     */
    public static function render(string|array $path, array $data = []): void
    {
        echo self::view($path, $data);
    }
}
