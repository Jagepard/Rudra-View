<?php

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\View;

interface ViewInterface
{
    public function setup(array $config): void;
    public function view($path, array $data = []);
    public function render($path, array $data = []);
    public function cache(array $path, $fullPage = true);
}
