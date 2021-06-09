<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\View;

use Rudra\Container\Traits\FacadeTrait;

/**
 * @method static void setup(array $config)
 * @method static string view(string $path, array $data = [])
 * @method static render($path, array $data = [])
 *
 * @see View
 */
final class ViewFacade
{
    use FacadeTrait;
}
