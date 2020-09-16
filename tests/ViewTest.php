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
use Rudra\View\{View, ViewInterface};
use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;

class ViewTest extends PHPUnit_Framework_TestCase
{

    protected ApplicationInterface $application;
    protected ViewInterface $controller;

    protected function setUp(): void
    {
        $_FILES = [
            "upload" =>
                ["name"     => ["img" => "demo.png"],
                 "type"     => ["img" => "image/png"],
                 "tmp_name" => ["img" => "/tmp/phpiQuDkR"],
                 "error"    => ["img" => 0],
                 "size"     => ["img" => 9584],
                ]
        ];

        $_POST = [
            "img"   => "http://example.com/images/img.png",
            'image' => "http://example.com/images/image.png",
        ];

        $this->application = Application::run();
        $this->application->config()->set([
            "bp"  => dirname(__DIR__) . '/',
            "env" => "development",
        ]);

        $this->application->binding()->set([ApplicationInterface::class => Application::run()]);
        $this->controller = new View($this->application);
        $this->controller->template([
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
        $this->assertEquals('"Hello World!!!"', $this->controller->view("index", ["title" => "title"]));
    }
}
