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
     * Configures paths for working with templates and caching.
     * Checks the existence of the template directory, sets basic parameters,
     * and also creates a directory for the cache if it does not exist.
     * --------------------
     * Настраивает пути для работы с шаблонами и кэшированием.
     * Проверяет существование директории шаблонов, устанавливает базовые параметры,
     * а также создаёт директорию для кэша, если она не существует.
     *
     * @param string $viewPath
     * @param string $prefix
     * @param string $extension
     * @return void
     */
    public function setup(string $viewPath, string $prefix = '', string $extension = 'phtml'): void
    {
        if (!is_dir($viewPath)) {
            throw new RuntimeException("The template directory does not exist: {$viewPath}");
        }

        $this->prefix = $prefix;
        $this->viewPath = rtrim($viewPath, '/\\');
        $this->extension = ltrim($extension, '.');

        $basePath = dirname(__DIR__, 4);
        $this->cachePath = $basePath . '/app/cache/templates';

        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0777, true);
        }
    }

    /**
     * Renders a view (template) at the specified path, substituting the passed data.
     * If `$path` is an array, the first element is used as the path to the template,
     * and the second element is used as the name to save the result in the cache.
     * --------------------
     * Рендерит вид (шаблон) по указанному пути, подставляя переданные данные.
     * Если `$path` — массив, первый элемент используется как путь к шаблону,
     * второй — как имя для сохранения результата в кэш.
     *
     * @param string|array $path
     * @param array $data
     * @return string|false
     */
    public function view(string|array $path, array $data = []): string|false
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
     * Checks the cache at the specified path and returns the saved content if it is up-to-date.
     * If the cache is outdated or missing, returns null.
     * --------------------
     * Проверяет кэш по указанному пути и возвращает сохранённое содержимое, если оно актуально.
     * Если кэш устарел или отсутствует, возвращает null.
     * 
     * @param array $path
     * @param boolean $fullPage
     * @return string|null
     */
    public function cache(array $path, bool $fullPage = false): ?string
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
