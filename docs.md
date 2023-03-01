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
|public|<em><strong>setup</strong>( string $basePath  string $viewPath  ?string $cachePath  string $extension ): void</em><br>Setup basic parameters<br>Установка основных параметров|
|public|<em><strong>view</strong>(  $path  array $data ): string|false</em><br>Returns the html representation from the output buffer<br>Imports variables from the $data array into the template<br>When passing an array:<br>the html view is created according to the first parameter<br>and cache file according to the second<br>Возвращает html представление из буфера вывода<br>Импортирует переменные из массива $data в шаблон<br>При передаче массива:<br>создается html представление в соответствии с первым параметром <br>и файл кэша в соответствии со вторым|
|public|<em><strong>cache</strong>( array $path   $fullPage ): ?string</em><br>Checks the cache file against the caching frequency,<br>if the cache is out of date, then it must be updated<br>The default caching interval time is specified in the configuration file<br>config/setting.local.yml for local development config/setting.production.yml for public release<br>Example: 'cache.time' => 'now',<br>The caching interval time can be passed as the second parameter $time<br>Example: '+1 day'<br>The value of $fullPage true interrupts further code processing if the data in the cache file is uptodate<br>Example: cache('index', '+1 day', true); or cache('index', null, true);<br>Проверяет файл кэша на соответствие периодичности кэширования,<br>если кеш устарел, то он должен быть обновлен<br>Время периодичности кэширования по умолчанию указывается в файле конфигурации <br>config/setting.local.yml для локальной разработки config/setting.production.yml для публичного размещения<br>Пример: 'cache.time' => 'now', <br>Время периодичности кэширования можно передать вторым элементом массива $path[1]<br>Пример: '+1 day'<br>Значение $fullPage true прерывает дальнейшую обработку кода в случае актуальности данных в файле кэша<br>Пример: cache(['index', '+1 day'], true); или cache(['index'], true); // времяиз конфигурвции|
|public|<em><strong>__construct</strong>( Rudra\Container\Interfaces\RudraInterface $rudra )</em><br>|
|public|<em><strong>rudra</strong>(): Rudra\Container\Interfaces\RudraInterface</em><br>|


<a id="rudra_view_viewfacade"></a>

### Class: Rudra\View\ViewFacade
| Visibility | Function |
|:-----------|:---------|
|public static|<em><strong>render</strong>(  $path  array $data ): void</em><br>Displays template<br>Отображает шаблон|
|public static|<em><strong>__callStatic</strong>(  $method   $parameters )</em><br>|


<a id="rudra_view_viewinterface"></a>

### Class: Rudra\View\ViewInterface
| Visibility | Function |
|:-----------|:---------|
|abstract public|<em><strong>setup</strong>( string $basePath  string $viewPath  ?string $cachePath  string $extension ): void</em><br>Setup basic parameters<br>Установка основных параметров|
|abstract public|<em><strong>view</strong>(  $path  array $data ): string|false</em><br>Returns the html representation from the output buffer<br>Imports variables from the $data array into the template<br>When passing an array:<br>the html view is created according to the first parameter<br>and cache file according to the second<br>Возвращает html представление из буфера вывода<br>Импортирует переменные из массива $data в шаблон<br>При передаче массива:<br>создается html представление в соответствии с первым параметром <br>и файл кэша в соответствии со вторым|
|abstract public|<em><strong>cache</strong>( array $path   $fullPage ): ?string</em><br>Checks the cache file against the caching frequency,<br>if the cache is out of date, then it must be updated<br>The default caching interval time is specified in the configuration file<br>config/setting.local.yml for local development config/setting.production.yml for public release<br>Example: 'cache.time' => 'now',<br>The caching interval time can be passed as the second parameter $time<br>Example: '+1 day'<br>The value of $fullPage true interrupts further code processing if the data in the cache file is uptodate<br>Example: cache('index', '+1 day', true); or cache('index', null, true);<br>Проверяет файл кэша на соответствие периодичности кэширования,<br>если кеш устарел, то он должен быть обновлен<br>Время периодичности кэширования по умолчанию указывается в файле конфигурации <br>config/setting.local.yml для локальной разработки config/setting.production.yml для публичного размещения<br>Пример: 'cache.time' => 'now', <br>Время периодичности кэширования можно передать вторым элементом массива $path[1]<br>Пример: '+1 day'<br>Значение $fullPage true прерывает дальнейшую обработку кода в случае актуальности данных в файле кэша<br>Пример: cache(['index', '+1 day'], true); или cache(['index'], true); // времяиз конфигурвции|
|abstract public|<em><strong>rudra</strong>(): Rudra\Container\Interfaces\RudraInterface</em><br>Service and Configuration Container<br>Контейнер сервисов и конфигураций|
<hr>

###### created with [Rudra-Markdown](#https://github.com/Jagepard/Rudra-Markdown)
