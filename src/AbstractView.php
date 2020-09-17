<?php

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\View;

abstract class AbstractView
{
    abstract protected function template(array $config): void;
    abstract protected function view(string $path, array $data = []): string;
    abstract protected function render(string $path, array $data = []);
}
