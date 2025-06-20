[![PHPunit](https://github.com/Jagepard/Rudra-View/actions/workflows/php.yml/badge.svg)](https://github.com/Jagepard/Rudra-View/actions/workflows/php.yml)
[![Maintainability](https://qlty.sh/badges/1f4a5583-4847-4680-9a41-6f627fd15348/maintainability.svg)](https://qlty.sh/gh/Jagepard/projects/Rudra-View)
[![CodeFactor](https://www.codefactor.io/repository/github/jagepard/rudra-view/badge)](https://www.codefactor.io/repository/github/jagepard/rudra-view)
[![Coverage Status](https://coveralls.io/repos/github/Jagepard/Rudra-View/badge.svg?branch=master)](https://coveralls.io/github/Jagepard/Rudra-View?branch=master)
-----

# Rudra-View | [API](https://github.com/Jagepard/Rudra-View/blob/master/docs.md "Documentation API")

### Install / Установка
```
composer require rudra/view
```
### Using facade / Используя фасад
```php
use Rudra\View\ViewFacade as View;

echo View::view("layout", [
    'content' => View::view("page", [
        'foo' => 'foo',
        'bar' => 'bar'
    ]),
]);
```
### With caching / С кешированием
```php
use Rudra\View\ViewFacade as View;

echo View::cache(['mainpage', "+1 day"]) ?? View::view(["layout", "mainpage"], [
    'content' => View::cache(["page_{$slug}", "+1 day"]) ?? View::view(["page", "page_{$slug}"], [
        'foo' => 'foo',
        'bar' => 'bar'
    ]),
]);
```
### Using render, view helpers / При помощи хелперов render, view
```php
render("layout", [
    'content' => view('page', [
        'foo' => 'foo',
        'bar' => 'bar'
    ]),
]);
```
### With setting data through the data helper / С установкой данных через хелпер data
```php
data([
    'content' => view("page", [
        'foo' => 'foo',
        'bar' => 'bar'
    ]),
]);

render("layout", data());
```
### With caching / С кешированием
```php
data([
    'content' => cache(["page_{$slug}", "+1 day") ?? view(["page", "page_{$slug}"], [
        'foo' => 'foo',
        'bar' => 'bar'
    ]),
]);

cache(["mainpage", "+1 day"]) ?? render(["layout", "mainpage"], data()));
```