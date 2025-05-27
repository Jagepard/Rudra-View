<?php

declare(strict_types=1);

/**
 * @author  : Jagepard <jagepard@yandex.ru>
 * @license https://mit-license.org/  MIT
 */

namespace Rudra\View;

class View implements ViewInterface
{
    private string $prefix;
    private string $viewPath;
    private string $cachePath;
    private string $extension;

    /**
     * Configures the view engine by setting up paths and default parameters.
     *
     * This method performs the following:
     * 1. Validates that the specified template directory (`$viewPath`) exists.
     * 2. Sets the base path for templates and the file extension for views.
     * 3. Ensures that the cache directory exists, creating it if necessary.
     *
     * @param string $viewPath The absolute path to the directory containing view templates.
     *                         Must be a valid directory.
     * @param string $prefix An optional prefix to prepend to view names (e.g., 'admin.' or 'user.').
     *                       Defaults to an empty string.
     * @param string $extension The file extension for view templates (e.g., 'phtml', 'php').
     *                          Defaults to 'phtml'.
     *
     * @throws \InvalidArgumentException If the specified `$viewPath` is not a valid directory.
     */
    public function setup(string $viewPath, string $prefix = '', string $extension = 'phtml'): void
    {
        if (!is_dir($viewPath)) {
            throw new \InvalidArgumentException("The template directory does not exist: {$viewPath}");
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
     * Renders a template and returns its output as a string.
     * 
     * This method supports rendering templates from a single path or a combination of paths. If an array is provided
     * as the `$path`, the first element is rendered, and the output is cached using the second element as the cache key.
     * 
     * The method performs the following:
     * 1. Checks if `$path` is an array:
     *    - Renders the first element as the template.
     *    - Caches the output in the specified cache path using the second element as the cache key.
     * 2. If `$path` is a string, it resolves the full path to the template file and renders it.
     * 3. Extracts the `$data` array into variables for use within the template.
     * 4. Returns the rendered output as a string or `false` if the template file does not exist.
     *
     * @param string|array $path The template path or an array containing:
     *                           - The primary template path to render.
     *                           - (Optional) A cache key for storing the rendered output.
     * @param array        $data An associative array of data to be extracted and used within the template.
     * 
     * @return string|false The rendered template output as a string, or `false` if the template file does not exist.
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
     * Checks if a cached version of a template is valid and returns its content.
     * 
     * This method performs the following:
     * 1. Constructs the cache file path based on the provided `$path` and configuration.
     * 2. Checks if the cache file exists and is still valid based on the specified lifetime (`$path[1]` or default config).
     * 3. If the cache is valid:
     *    - Returns the cached content as a string.
     *    - Optionally outputs the content and terminates the script if `$fullPage` is `true`.
     * 4. Returns `null` if the cache is invalid or does not exist.
     *
     * @param array $path An array containing:
     *                    - The template path used to generate the cache key.
     *                    - (Optional) The cache lifetime, which can be a time string (e.g., '+1 hour') or fetched from config.
     * @param bool $fullPage Whether to output the cached content directly and terminate the script. Defaults to `false`.
     * 
     * @return string|null The cached content as a string, or `null` if the cache is invalid or does not exist.
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
