## Table of contents
- [Rudra\View\TwigView](#rudra_view_twigview)
- [Rudra\View\View](#rudra_view_view)
- [Rudra\View\ViewFacade](#rudra_view_viewfacade)
- [Rudra\View\ViewInterface](#rudra_view_viewinterface)


---



<a id="rudra_view_twigview"></a>

### Class: Rudra\View\TwigView
| Visibility | Function |
|:-----------|:---------|
| public | `setup(string $viewPath, string $prefix, string $extension): void`<br>Configures paths for working with Twig templates and caching.<br>Checks the existence of the template directory, sets basic parameters,<br>and initializes the Twig environment with caching enabled. |
| public | `view(array\|string $path, array $data): string\|false`<br>Renders a Twig template at the specified path, substituting the passed data.<br>If `$path` is an array, the first element is used as the template name,<br>and the rendered result is returned (external caching may be applied if needed). |
| public | `cache(array $path, bool $fullPage): ?string`<br>Page-level caching is not supported in TwigView, as Twig handles template compilation caching internally.<br>This method throws an exception to indicate that HTTP-level or application-level caching should be used instead. |


<a id="rudra_view_view"></a>

### Class: Rudra\View\View
| Visibility | Function |
|:-----------|:---------|
| public | `setup(string $viewPath, string $prefix, string $extension): void`<br>Configures paths for working with templates and caching.<br>Checks the existence of the template directory, sets basic parameters,<br>and also creates a directory for the cache if it does not exist. |
| public | `view(array\|string $path, array $data): string\|false`<br>Renders a view (template) at the specified path, substituting the passed data.<br>If `$path` is an array, the first element is used as the path to the template,<br>and the second element is used as the name to save the result in the cache. |
| public | `cache(array $path, bool $fullPage): ?string`<br>Checks the cache at the specified path and returns the saved content if it is up-to-date.<br>If the cache is outdated or missing, returns null. |


<a id="rudra_view_viewfacade"></a>

### Class: Rudra\View\ViewFacade
| Visibility | Function |
|:-----------|:---------|
| public static | `render(array\|string $path, array $data): void`<br>Renders the template at the specified path and outputs the result to the screen. |
| public static | `__callStatic(string $method, array $parameters): mixed`<br>Handles static method calls for the Facade class<br>It dynamically resolves the underlying class name by removing "Facade" from the class name<br>If the resolved class does not exist, it attempts to clean up the class name by removing spaces<br>If the resolved class is not already registered in the container, it registers it<br>Finally, it delegates the static method call to the resolved class instance |


<a id="rudra_view_viewinterface"></a>

### Class: Rudra\View\ViewInterface
| Visibility | Function |
|:-----------|:---------|
| abstract public | `setup(string $viewPath, string $prefix, string $extension): void`<br> |
| abstract public | `view(array\|string $path, array $data): string\|false`<br> |
| abstract public | `cache(array $path, bool $fullPage): ?string`<br> |


---

###### created with [Rudra-Documentation-Collector](https://github.com/Jagepard/Rudra-Documentation-Collector)
