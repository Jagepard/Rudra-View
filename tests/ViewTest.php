<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 *
 * phpunit src/tests/ControllerTest --coverage-html src/tests/coverage-html
 */

namespace Rudra\View\Tests;

use Rudra\Container\{Container, Facades\Rudra, Interfaces\RudraInterface};
use Rudra\View\ViewFacade as View;
use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;

class ViewTest extends PHPUnit_Framework_TestCase
{
    protected function setUp(): void
    {
        Rudra::setServices(
            [
                "contracts" => [
                    RudraInterface::class => Rudra::run(),
                ],

                "services" => [
                    View::class => View::class,
                ]
            ]
        );

        View::setup([
            "base.path"      => dirname(__DIR__) . '/',
            "engine"         => "native",
            "view.path"      => "app/resources/tmpl",
            "file.extension" => "tmpl.php"
        ]);
    }

    /**
     * @runInSeparateProcess
     */
    public function testView()
    {
        $this->assertEquals('"Hello World!!!"', View::view("index", ["title" => "title"]));
    }
}
