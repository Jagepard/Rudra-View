<?php 

declare(strict_types=1);

/**
 * @author  : Jagepard <jagepard@yandex.ru>
 * @license https://mit-license.org/  MIT
 */

namespace Rudra\View;

use Rudra\Container\Interfaces\RudraInterface;

interface ViewInterface
{
    public function setup(string $viewPath, string $prefix = '', string $extension = 'phtml'): void;
    public function view($path, array $data = []): string|false;
    public function cache(array $path, $fullPage = false): ?string;
}
