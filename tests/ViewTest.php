<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 *
 * phpunit src/tests/ControllerTest --coverage-html src/tests/coverage-html
 */

namespace Rudra\View\Tests;

use PHPUnit\Framework\TestCase;
use Rudra\View\ViewFacade as View;
use Rudra\Container\{Container, Facades\Rudra, Interfaces\RudraInterface};

class ViewTest extends TestCase
{
    protected function setUp(): void
    {
        Rudra::binding([RudraInterface::class => Rudra::run()]);
        Rudra::services([View::class => View::class]);

        View::setup(dirname(__DIR__) . '/'. "app/resources/tmpl");
    }

    /**
     * @runInSeparateProcess
     */
    public function testView()
    {
        $this->assertEquals('"Hello World!!!"', view(['index', 'index_cache'], ["name" => "World"]));
        $this->assertEquals('"Hello John!!!"', view("index", ["name" => "John"]));
    }

    public function testCache()
    {
        $this->assertEquals('"Hello World!!!"', cache(['index_cache', '+1 day']));

        echo View::view(["layout", "page_{$slug}"], [
            'content' => View::cache(['index_cache', '+1 day']) ?? View::view(['index', 'index_cache'], [
                'foo' => 'foo',
                'bar' => 'bar'
            ]),
        ]);
    }
}
