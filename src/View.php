<?php

declare(strict_types=1);

/**
 * @author  : Jagepard <jagepard@yandex.ru>
 * @license https://mit-license.org/  MIT
 */

namespace Rudra\View;

use Rudra\Exceptions\RuntimeException;

class View implements ViewInterface
{
    private string $prefix;
    private string $viewPath;
    private string $cachePath;
    private string $extension;

    /**
     * Sets the path to the folder with templates, prefix, and template file extension
     * -------------------------------------------------------------------------------
     * Устанавливает путь к папке с шаблонами, префикс и расширение файла шаблонов
     * 
     * @param  string $viewPath
     * @param  string $prefix
     * @param  string $extension
     * @return void
     */
    public function setup(string $viewPath, string $prefix = '', string $extension = 'phtml'): void
    {
        if (!is_dir($viewPath)) {
            throw new RuntimeException("The template directory does not exist: {$viewPath}");
        }

        $this->viewPath = rtrim($viewPath, '/\\');
        $this->prefix = $prefix;
        $this->extension = ltrim($extension, '.');

        $basePath = dirname(__DIR__, 4);
        $this->cachePath = $basePath . '/app/cache/templates';

        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0777, true);
        }
    }

    /**
     * Renders a view template or caches it if path is an array.
     * ---------------------------------------------------------
     * Отображает шаблон или кэширует его, если путь является массивом.
     *
     * @param               $path
     * @param  array        $data
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

        if (!empty($data)) { 
            extract($data, EXTR_REFS);
        }

        if (file_exists($fullPath)) {
            require $fullPath;
        }

        return ob_get_clean();
    }

    /**
     * Caches the template
     * -------------------
     * Кэширует шаблон
     *
     * @param  array       $path
     * @param  boolean     $fullPage
     * @return string|null
     */
    public function cache(array $path, $fullPage = false): ?string
    {
        $cachePath = $this->cachePath . '/' . $this->prefix . str_replace('.', '/', $path[0]) . '.' . $this->extension;
        $cacheTime = $path[1] ?? config('cache.time', 'templates');

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
