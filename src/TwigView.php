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

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Rudra\Exceptions\RuntimeException;

class TwigView implements ViewInterface
{
    private Environment $twig;
    private string $cachePath;
    private string $prefix;

    /**
     * Configures paths for working with Twig templates and caching.
     * Checks the existence of the template directory, sets basic parameters,
     * and initializes the Twig environment with caching enabled.
     * --------------------
     * Настраивает пути для работы с шаблонами Twig и кэшированием.
     * Проверяет существование директории шаблонов, устанавливает базовые параметры
     * и инициализирует окружение Twig с включённым кэшированием.
     *
     * @param string $viewPath
     * @param string $prefix
     * @param string $extension
     * @return void
     */
    public function setup(string $viewPath, string $prefix = '', string $extension = 'twig'): void
    {
        if (!is_dir($viewPath)) {
            throw new RuntimeException("The template directory does not exist: {$viewPath}");
        }

        $this->prefix = $prefix;

        $basePath = dirname(__DIR__, 4);
        $this->cachePath = $basePath . '/storage/cache/twig';

        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0777, true);
        }

        $loader = new FilesystemLoader($viewPath);
        $this->twig = new Environment($loader, [
            'cache' => $this->cachePath,
            'auto_reload' => true,
            'debug' => false,
        ]);
    }

    /**
     * Renders a Twig template at the specified path, substituting the passed data.
     * If `$path` is an array, the first element is used as the template name,
     * and the rendered result is returned (external caching may be applied if needed).
     * --------------------
     * Рендерит шаблон Twig по указанному пути, подставляя переданные данные.
     * Если `$path` — массив, первый элемент используется как имя шаблона,
     * а результат рендеринга возвращается (при необходимости может применяться внешнее кэширование).
     *
     * @param string|array $path
     * @param array $data
     * @return string|false
     */
    public function view(string|array $path, array $data = []): string|false
    {
        if (is_array($path)) {
            $output = $this->twig->render($path[0] . '.twig', $data);
            // Внешнее именованное кэширование возможно, но обычно не требуется — Twig кэширует компиляцию сам.
            return $output;
        }

        return $this->twig->render($path . '.twig', $data);
    }

    /**
     * Page-level caching is not supported in TwigView, as Twig handles template compilation caching internally.
     * This method throws an exception to indicate that HTTP-level or application-level caching should be used instead.
     * --------------------
     * Кэширование на уровне страницы не поддерживается в TwigView, так как Twig сам управляет кэшированием компиляции шаблонов.
     * Этот метод выбрасывает исключение, чтобы указать: следует использовать кэширование на уровне HTTP или приложения.
     *
     * @param array $path
     * @param boolean $fullPage
     * @return string|null
     * @throws RuntimeException
     */
    public function cache(array $path, bool $fullPage = false): ?string
    {
        throw new RuntimeException('Caching via cache() is not supported in TwigView. Use HTTP-level caching instead.');
    }
}
