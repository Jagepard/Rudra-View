<?php declare(strict_types=1);

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 * 
 * phpunit src/tests/ContainerTest --coverage-html src/tests/coverage-html
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
    }
}
