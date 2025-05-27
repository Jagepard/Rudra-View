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
|public|<em><strong>setup</strong>( string $viewPath  string $prefix  string $extension ): void</em><br>|
|public|<em><strong>view</strong>(  $path  array $data ): string|false</em><br>|
|public|<em><strong>cache</strong>( array $path   $fullPage ): ?string</em><br>|


<a id="rudra_view_viewfacade"></a>

### Class: Rudra\View\ViewFacade
| Visibility | Function |
|:-----------|:---------|
|public static|<em><strong>render</strong>(  $path  array $data ): void</em><br>|
|public static|<em><strong>__callStatic</strong>( string $method  array $parameters ): mixed</em><br>|


<a id="rudra_view_viewinterface"></a>

### Class: Rudra\View\ViewInterface
| Visibility | Function |
|:-----------|:---------|
|abstract public|<em><strong>setup</strong>( string $viewPath  string $prefix  string $extension ): void</em><br>|
|abstract public|<em><strong>view</strong>(  $path  array $data ): string|false</em><br>|
|abstract public|<em><strong>cache</strong>( array $path   $fullPage ): ?string</em><br>|
<hr>

###### created with [Rudra-Documentation-Collector](#https://github.com/Jagepard/Rudra-Documentation-Collector)
