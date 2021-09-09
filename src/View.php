<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\View;

use Rudra\Container\Facades\Rudra;

class View implements ViewInterface
{
    private array $config;
    private string $basePath;

    public function setup(array $config): void
    {
        if (!array_key_exists("base.path", $config)) {
            throw new \InvalidArgumentException("'base.path' does not exist in config");
        }

        $this->basePath = $config["base.path"];

        switch ($config["engine"]) {
            case "native":
                $this->config = $config;
                break;
        }
    }

    public function view(string $path, array $data = []): string
    {
        $path = $this->basePath . $this->config["view.path"] . '/'
            . str_replace('.', '/', $path) . '.' . $this->config["file.extension"];

        ob_start();

        if (count($data)) extract($data, EXTR_REFS);
        if (file_exists($path)) require $path;

        return ob_get_clean();
    }

    public function render($path, array $data = [])
    {
        if (is_array($path)) {
            $output = $this->view($path[0], $data);
            $cachePath = $this->basePath . $this->config["cache.path"] . '/'
                . str_replace('.', '/', $path[1]) . '.' . $this->config["file.extension"];

            file_put_contents($cachePath, $output);
            echo $output;
            return;
        }

        echo $this->view($path, $data);
    }

    public function cache(array $path)
    {
        $cachePath = $this->basePath . $this->config["cache.path"] . '/'
            . str_replace('.', '/', $path[0]) . '.' . $this->config["file.extension"];

        $cacheTime = $path[1] ?? Rudra::config()->get('cache.time');

        if (file_exists($cachePath) && (strtotime($cacheTime, filemtime($cachePath)) > time())) {
            echo file_get_contents($cachePath);
            exit();
        }
    }
}
