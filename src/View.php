<?php

declare(strict_types=1);

/**
 * @author  : Jagepard <jagepard@yandex.ru>
 * @license https://mit-license.org/  MIT
 */

namespace Rudra\View;

use Rudra\Container\Traits\SetRudraContainersTrait;

class View implements ViewInterface
{
    use SetRudraContainersTrait;

    private string $prefix;
    private string $viewPath;
    private string $cachePath;
    private string $extension;

    /**
     * Sets up the view engine parameters.
     *
     * @param string $viewPath
     * @param string $prefix
     * @param string $extension
     */
    public function setup(string $viewPath, string $prefix = '', string $extension = 'phtml'): void
    {
        if (!is_dir($viewPath)) {
            throw new \InvalidArgumentException("Директория шаблонов не существует: {$viewPath}");
        }

        $this->viewPath  = rtrim($viewPath, '/\\');
        $this->prefix    = $prefix;
        $this->extension = ltrim($extension, '.');

        $basePath = dirname(__DIR__, 4);
        $this->cachePath = $basePath . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'templates';

        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0777, true);
        }
    }

    /**
     * Renders a template and returns it as a string.
     *
     * @param string|array $path
     * @param array        $data
     * @return string|false
     */
    public function view($path, array $data = []): string|false
    {
        if (is_array($path)) {
            $output = $this->view($path[0], $data);
            $cachePath = $this->cachePath . '/' . str_replace('.', '/', $this->prefix . $path[1]) . '.' . $this->extension;

            file_put_contents($cachePath, $output);
            return $output;
        }

        $fullPath = $this->viewPath . '/' . str_replace('.', '/', $path) . '.' . $this->extension;

        ob_start();

        if (!empty($data)) extract($data, EXTR_REFS);
        if (file_exists($fullPath)) require $fullPath;

        return ob_get_clean();
    }

    /**
     * Checks if a cached version is valid.
     *
     * @param array   $path
     * @param boolean $fullPage
     * @return string|null
     */
    public function cache(array $path, $fullPage = false): ?string
    {
        $cachePath = $this->cachePath . '/' . $this->prefix . str_replace('.', '/', $path[0]) . '.' . $this->extension;
        $cacheTime = $path[1] ?? $this->rudra()?->config()?->get('cache.time');

        if (file_exists($cachePath)) {
            $cacheLifetime = strtotime((string) $cacheTime, filemtime($cachePath));
            if ($cacheLifetime > time()) {
                $content = file_get_contents($cachePath);
                if ($fullPage) {
                    echo $content;
                    exit;
                }
                return $content;
            }
        }

        return null;
    }
}
