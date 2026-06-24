<?php declare(strict_types=1);

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 */

namespace Rudra\View\Tests;

use Rudra\Container\Container;
use Rudra\Container\Facades\Rudra;
use Rudra\Container\Interfaces\RudraInterface;
use Rudra\View\ViewFacade as View;
use Rudra\Exceptions\RuntimeException;

class ViewTest extends \PHPUnit\Framework\TestCase
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

    public function testNonExistentTemplateReturnsFalse()
    {
        $result = view("non_existent_template", []);
        $this->assertFalse($result);
    }

    public function testNonExistentDirectoryThrowsException()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The template directory does not exist');
        
        View::setup('/non/existent/directory');
    }

    public function testViewWithEmptyData()
    {
        $result = view("index", []);
        $this->assertIsString($result);
    }
}
