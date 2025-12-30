<?php declare(strict_types=1);

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
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
