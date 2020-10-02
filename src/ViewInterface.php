<?php

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\View;

interface ViewInterface
{
    public function setup(array $config): void;
    public function view(string $path, array $data = []): string;
    public function render(string $path, array $data = []);
}
