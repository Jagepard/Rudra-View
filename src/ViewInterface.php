<?php 

declare(strict_types=1);

/**
 * @author  : Jagepard <jagepard@yandex.ru>
 * @license https://mit-license.org/  MIT
 */

namespace Rudra\View;

use Rudra\Container\Interfaces\RudraInterface;

/**
 * ViewInterface
 *
 * Interface for working with a template engine.
 */
interface ViewInterface
{
    /**
     * Sets up the view engine parameters.
     *
     * @param string $viewPath
     * @param string $prefix
     * @param string $extension
     */
    public function setup(string $viewPath, string $prefix = '', string $extension = 'phtml'): void;

    /**
     * Renders a template and returns it as a string.
     *
     * @param string|array $path
     * @param array        $data
     * @return string|false
     */
    public function view($path, array $data = []): string|false;

    /**
     * Checks if a cached version is valid.
     *
     * @param array   $path
     * @param boolean $fullPage
     * @return string|null
     */
    public function cache(array $path, $fullPage = false): ?string;

    /**
     * Returns the service and configuration container.
     *
     * @return RudraInterface
     */
    public function rudra(): RudraInterface;
}
