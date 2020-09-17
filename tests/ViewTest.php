<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 *
 * phpunit src/tests/ControllerTest --coverage-html src/tests/coverage-html
 */

namespace Rudra\View\Tests;

use Rudra\Container\{Application, Interfaces\ApplicationInterface};
use Rudra\View\View;
use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;

class ViewTest extends PHPUnit_Framework_TestCase
{
    protected function setUp(): void
    {
        Application::run()->config()->set([
            "bp"  => dirname(__DIR__) . '/'
        ]);

        Application::run()->setServices(
            [
                "contracts" => [
                    ApplicationInterface::class => Application::run(),
                ],

                "services" => [
                    View::$alias => View::class,
                ],
            ]
        );

        View::template([
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
