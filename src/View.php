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
    use SetRudraContainersTrait;

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

    public function view($path, array $data = [])
    {
        if (is_array($path)) {
            $output = $this->view($path[0], $data);
            $cachePath = $this->basePath . $this->config["cache.path"] . DIRECTORY_SEPARATOR
                . str_replace('.', DIRECTORY_SEPARATOR, $path[1]) . '.' . $this->config["file.extension"];

            file_put_contents($cachePath, $output);
            return $output;
        }

        $path = $this->basePath . $this->config["view.path"] . DIRECTORY_SEPARATOR
            . str_replace('.', DIRECTORY_SEPARATOR, $path) . '.' . $this->config["file.extension"];

        ob_start();

        if (count($data)) extract($data, EXTR_REFS);
        if (file_exists($path)) require $path;

        return ob_get_clean();
    }

    public function render($path, array $data = [])
    {
        if (is_array($path)) {
            $output = $this->view($path[0], $data);
            $cachePath = $this->basePath . $this->config["cache.path"] . DIRECTORY_SEPARATOR
                . str_replace('.', DIRECTORY_SEPARATOR, $path[1]) . '.' . $this->config["file.extension"];

            file_put_contents($cachePath, $output);
            echo $output;
            return;
        }

        echo $this->view($path, $data);
    }

    public function cache(array $path, $fullPage = false)
    {
        $cachePath = $this->basePath . $this->config["cache.path"] . DIRECTORY_SEPARATOR
            . str_replace('.', DIRECTORY_SEPARATOR, $path[0]) . '.' . $this->config["file.extension"];

        $cacheTime = $path[1] ?? $this->rudra()->config()->get('cache.time');

        if (file_exists($cachePath) && (strtotime($cacheTime, filemtime($cachePath)) > time())) {
            if ($fullPage) {
                echo file_get_contents($cachePath);
                exit();
            }

            return file_get_contents($cachePath);
        }
    }
}
