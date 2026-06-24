[![PHPunit](https://github.com/Jagepard/Rudra-View/actions/workflows/php.yml/badge.svg)](https://github.com/Jagepard/Rudra-View/actions/workflows/php.yml)
[![Maintainability](https://qlty.sh/badges/1f4a5583-4847-4680-9a41-6f627fd15348/maintainability.svg)](https://qlty.sh/gh/Jagepard/projects/Rudra-View)
[![CodeFactor](https://www.codefactor.io/repository/github/jagepard/rudra-view/badge)](https://www.codefactor.io/repository/github/jagepard/rudra-view)
[![Coverage Status](https://coveralls.io/repos/github/Jagepard/Rudra-View/badge.svg?branch=master)](https://coveralls.io/github/Jagepard/Rudra-View?branch=master)
-----

# Rudra-View | [API](https://github.com/Jagepard/Rudra-View/blob/master/docs.md "Documentation API")

### Install
```
composer require rudra/view
```
### Using facade
```php
use Rudra\View\ViewFacade as View;

echo View::view("layout", [
    'content' => View::view("page", [
        'foo' => 'foo',
        'bar' => 'bar'
    ]),
]);
```
### With caching
```php
use Rudra\View\ViewFacade as View;

echo View::cache(['mainpage', "+1 day"]) ?? View::render(["layout", "mainpage"], [
    'content' => View::cache(["page_{$slug}", "+1 day"]) ?? View::view(["page", "page_{$slug}"], [
        'foo' => 'foo',
        'bar' => 'bar'
    ]),
]);
```
### Using render, view helpers
```php
render("layout", [
    'content' => view('page', [
        'foo' => 'foo',
        'bar' => 'bar'
    ]),
]);
```
### With setting data through the data helper
```php
data([
    'content' => view("page", [
        'foo' => 'foo',
        'bar' => 'bar'
    ]),
]);

render("layout", data());
```
### With caching
```php
data([
    'content' => cache(["page_{$slug}", "+1 day"]) ?? view(["page", "page_{$slug}"], [
        'foo' => 'foo',
        'bar' => 'bar'
    ]),
]);

cache(["mainpage", "+1 day"]) ?? render(["layout", "mainpage"], data());
```

### Adding Twig
```bash
composer require "twig/twig:^3.0"
```

Create factory:
```php
<?php

namespace App\Containers\Web\Factory;

use Rudra\View\View;
use Rudra\View\TwigView;
use Rudra\Container\Interfaces\FactoryInterface;

class TwigFactory implements FactoryInterface
{
    public function create(): TwigView
    {
        $view = new TwigView();
        $view->setup(
            viewPath: dirname(dirname(__DIR__)) . '/Web/UI/tmpl',
            prefix: '',
            extension: 'twig'
        );

        return $view;
    }
}
```
Configure service:
```php
<?php

use Rudra\View\View;
use Rudra\View\TwigView;
use App\Containers\Web\Factory\TwigFactory;

return [
    'contracts' => [

    ],
    'services'  => [
        // View::class => function () {
        //     $view = new TwigView();
        //     $view->setup(
        //         viewPath: dirname(__DIR__) . '/Web/UI/tmpl',
        //         prefix: '',
        //         extension: 'twig'
        //     );
        //     return $view;
        // }
        // View::class => fn() => (new TwigFactory())->create(),

        View::class => TwigFactory::class,
    ]
];
```
## License

This project is licensed under the **Mozilla Public License 2.0 (MPL-2.0)** — a free, open-source license that:

- Requires preservation of copyright and license notices,
- Allows commercial and non-commercial use,
- Requires that any modifications to the original files remain open under MPL-2.0,
- Permits combining with proprietary code in larger works.

📄 Full license text: [LICENSE](./LICENSE)  
🌐 Official MPL-2.0 page: https://mozilla.org/MPL/2.0/
