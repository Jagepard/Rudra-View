<?php

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 */

namespace Rudra\View;

use Rudra\Container\Interfaces\RudraInterface;

interface ViewInterface
{
    public function setup(string $viewPath, string $prefix = '', string $extension = 'phtml'): void;
    public function view(string|array $path, array $data = []): string|false;
    public function cache(array $path, bool $fullPage = false): ?string;
}
