<?php declare(strict_types=1);

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 */

namespace Rudra\View;

use Rudra\Exceptions\RuntimeException;

class View implements ViewInterface
{
    private string $prefix = '';
    private string $viewPath  = '';
    private string $cachePath = '';
    private string $extension = 'phtml';

    /**
     * Configures paths for working with templates and caching.
     * Checks the existence of the template directory, sets basic parameters,
     * and also creates a directory for the cache if it does not exist.
     *
     * @throws RuntimeException
     */
    #[\Override]
    public function setup(string $viewPath, string $prefix = '', string $extension = 'phtml'): void
    {
        if (!is_dir($viewPath)) {
            throw new RuntimeException("The template directory does not exist: {$viewPath}");
        }

        if (!is_readable($viewPath)) {
            throw new RuntimeException("Template directory is not readable: {$viewPath}");
        }

        $this->prefix    = $prefix;
        $this->viewPath  = rtrim($viewPath, '/\\');
        $this->extension = ltrim($extension, '.');
        $this->cachePath = dirname(__DIR__, 4) . '/storage/cache/templates';

        // Safe directory creation with race condition handling
        if (!is_dir($this->cachePath) && !mkdir($this->cachePath, 0755, true)) {
            throw new RuntimeException("Failed to create cache directory: {$this->cachePath}");
        }
    }

    /**
     * Renders a view (template) at the specified path, substituting the passed data.
     * If `$path` is an array, the first element is used as the path to the template,
     * and the second element is used as the name to save the result in the cache.
     */
    #[\Override]
    public function view(string|array $path, array $data = []): string|false
    {
        if (is_array($path)) {
            $output    = $this->view($path[0], $data);
            $cachePath = $this->cachePath . '/' . str_replace('.', '/', $this->prefix . $path[1]) . '.' . $this->extension;

            if ($output === false) {
                return false;
            }

            file_put_contents($cachePath, $output);
            return $output;
        }

        $fullPath = $this->viewPath . '/' . str_replace('.', '/', $path) . '.' . $this->extension;

        // Check file existence BEFORE extract() to prevent variable injection
        if (!file_exists($fullPath)) {
            return false;
        }

        ob_start();

        if ($data !== []) { 
            extract($data, EXTR_SKIP);
        }

        require $fullPath;
        return ob_get_clean();
    }

    /**
     * Checks the cache at the specified path and returns the saved content if it is up-to-date.
     * If the cache is outdated or missing, returns null.
     */
    #[\Override]
    public function cache(array $path, bool $fullPage = false): ?string
    {
        $cachePath = $this->cachePath . '/' . str_replace('.', '/', $this->prefix . $path[0]) . '.' . $this->extension;
        $cacheTime = $path[1] ?? config('cache.time', 'templates');

        if (file_exists($cachePath)) {
            // filemtime() returns int|false, strict comparison required
            $filemtime = filemtime($cachePath);
            if ($filemtime === false) {
                return null;
            }
            
            // strtotime() returns int|false, must validate before comparison
            $cacheLifetime = strtotime((string) $cacheTime, $filemtime);
            if ($cacheLifetime === false || $cacheLifetime <= time()) {
                return null;
            }
            
            // file_get_contents() returns string|false, method signature requires ?string
            $content = file_get_contents($cachePath);
            if ($content === false) {
                return null;
            }
            
            if ($fullPage) {
                echo $content;
                exit;
            }
            
            return $content;
        }

        return null;
    }
}
