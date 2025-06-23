<?php 

declare(strict_types=1);

/**
 * @author  : Jagepard <jagepard@yandex.ru>
 * @license https://mit-license.org/  MIT
 */

namespace Rudra\View;

use Rudra\Container\Interfaces\RudraInterface;

interface ViewInterface
{
    /**
     * Configures paths for working with templates and caching.
     * Checks the existence of the template directory, sets basic parameters,
     * and also creates a directory for the cache if it does not exist.
     * -------------------------------------------------------------------------------
     * Настраивает пути для работы с шаблонами и кэшированием.
     * Проверяет существование директории шаблонов, устанавливает базовые параметры,
     * а также создаёт директорию для кэша, если она не существует.
     */
    public function setup(string $viewPath, string $prefix = '', string $extension = 'phtml'): void;

    /**
     * Renders a view (template) at the specified path, substituting the passed data.
     * If $path is an array, the first element is used as the path to the template,
     * and the second element is used as the name to save the result in the cache.
     * ---------------------------------------------------------------------------
     * Рендерит вид (шаблон) по указанному пути, подставляя переданные данные.
     * Если $path — массив, первый элемент используется как путь к шаблону,
     * второй — как имя для сохранения результата в кэш.
     */
    public function view($path, array $data = []): string|false;

    /**
     * Checks the cache at the specified path and returns the saved content if it is up-to-date.
     * If the cache is outdated or missing, returns null.
     * --------------------------------------------------
     * Проверяет кэш по указанному пути и возвращает сохранённое содержимое, если оно актуально.
     * Если кэш устарел или отсутствует, возвращает null.
     */
    public function cache(array $path, $fullPage = false): ?string;
}
