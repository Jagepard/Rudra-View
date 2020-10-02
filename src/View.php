<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\View;

use Rudra\Container\Traits\SetRudraContainersTrait;

class View implements ViewInterface
{
    use ViewTrait;
    use SetRudraContainersTrait;

    private array $template;
    private string $basePath;

    public function setup(array $config): void
    {
        if (!array_key_exists("base.path", $config)) {
            throw new \InvalidArgumentException("'base.path' does not exist in config");
        }

        $this->basePath = $config["base.path"];

        switch ($config["engine"]) {
            case "native":
                $this->template = $config;
                break;
        }
    }

    public function view(string $path, array $data = []): string
    {
        $path = $this->basePath . $this->template["view.path"] . '/'
            . str_replace('.', '/', $path) . '.' . $this->template["file.extension"];

        ob_start();

        if (count($data)) extract($data, EXTR_REFS);
        if (file_exists($path)) require_once $path;

        return ob_get_clean();
    }

    public function render(string $path, array $data = [])
    {
        echo $this->view($path, $data);
    }
}
