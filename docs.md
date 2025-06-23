## Table of contents
- [Rudra\View\View](#rudra_view_view)
- [Rudra\View\ViewFacade](#rudra_view_viewfacade)
- [Rudra\View\ViewInterface](#rudra_view_viewinterface)
<hr>

<a id="rudra_view_view"></a>

### Class: Rudra\View\View
##### implements [Rudra\View\ViewInterface](#rudra_view_viewinterface)
| Visibility | Function |
|:-----------|:---------|
|public|<em><strong>setup</strong>( string $viewPath  string $prefix  string $extension ): void</em><br>Configures paths for working with templates and caching.<br>Checks the existence of the template directory, sets basic parameters,<br>and also creates a directory for the cache if it does not exist.<br>Настраивает пути для работы с шаблонами и кэшированием.<br>Проверяет существование директории шаблонов, устанавливает базовые параметры,<br>а также создаёт директорию для кэша, если она не существует.|
|public|<em><strong>view</strong>(  $path  array $data ): string|false</em><br>Renders a view (template) at the specified path, substituting the passed data.<br>If $path is an array, the first element is used as the path to the template,<br>and the second element is used as the name to save the result in the cache.<br>Рендерит вид (шаблон) по указанному пути, подставляя переданные данные.<br>Если $path — массив, первый элемент используется как путь к шаблону,<br>второй — как имя для сохранения результата в кэш.|
|public|<em><strong>cache</strong>( array $path   $fullPage ): ?string</em><br>Checks the cache at the specified path and returns the saved content if it is uptodate.<br>If the cache is outdated or missing, returns null.<br>Проверяет кэш по указанному пути и возвращает сохранённое содержимое, если оно актуально.<br>Если кэш устарел или отсутствует, возвращает null.|


<a id="rudra_view_viewfacade"></a>

### Class: Rudra\View\ViewFacade
| Visibility | Function |
|:-----------|:---------|
|public static|<em><strong>render</strong>(  $path  array $data ): void</em><br>Renders the template at the specified path and outputs the result to the screen.<br>Рендерит шаблон по указанному пути и выводит результат на экран.|
|public static|<em><strong>__callStatic</strong>( string $method  array $parameters ): mixed</em><br>|


<a id="rudra_view_viewinterface"></a>

### Class: Rudra\View\ViewInterface
| Visibility | Function |
|:-----------|:---------|
|abstract public|<em><strong>setup</strong>( string $viewPath  string $prefix  string $extension ): void</em><br>Configures paths for working with templates and caching.<br>Checks the existence of the template directory, sets basic parameters,<br>and also creates a directory for the cache if it does not exist.<br>Настраивает пути для работы с шаблонами и кэшированием.<br>Проверяет существование директории шаблонов, устанавливает базовые параметры,<br>а также создаёт директорию для кэша, если она не существует.|
|abstract public|<em><strong>view</strong>(  $path  array $data ): string|false</em><br>Renders a view (template) at the specified path, substituting the passed data.<br>If $path is an array, the first element is used as the path to the template,<br>and the second element is used as the name to save the result in the cache.<br>Рендерит вид (шаблон) по указанному пути, подставляя переданные данные.<br>Если $path — массив, первый элемент используется как путь к шаблону,<br>второй — как имя для сохранения результата в кэш.|
|abstract public|<em><strong>cache</strong>( array $path   $fullPage ): ?string</em><br>Checks the cache at the specified path and returns the saved content if it is uptodate.<br>If the cache is outdated or missing, returns null.<br>Проверяет кэш по указанному пути и возвращает сохранённое содержимое, если оно актуально.<br>Если кэш устарел или отсутствует, возвращает null.|
<hr>

###### created with [Rudra-Documentation-Collector](#https://github.com/Jagepard/Rudra-Documentation-Collector)
