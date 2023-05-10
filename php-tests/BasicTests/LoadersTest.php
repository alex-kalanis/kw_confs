<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_confs\ConfException;
use kalanis\kw_confs\Config;
use kalanis\kw_confs\Interfaces\IConf;
use kalanis\kw_confs\Interfaces\ILoader;
use kalanis\kw_confs\Loaders\ClassLoader;
use kalanis\kw_confs\Loaders\MultiLoader;
use kalanis\kw_confs\Loaders\PhpLoader;
use kalanis\kw_paths\Path;
use kalanis\kw_paths\PathsException;
use kalanis\kw_routed_paths\RoutedPath;
use kalanis\kw_routed_paths\Sources as routeSource;


class LoadersTest extends CommonTestClass
{
    /**
     * @throws ConfException
     */
    public function testGetVirtualFile(): void
    {
        Config::init(new XYLoader());
        Config::load('dummy', 'hrk');
        $this->assertEquals('vwx%s', Config::get('dummy', 'jkl'));
    }

    /**
     * @throws ConfException
     * @throws PathsException
     */
    public function testGetRealFile(): void
    {
        $path = new Path();
        $path->setDocumentRoot(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data');
        $routed = new RoutedPath(new routeSource\Arrays([]));
        Config::init(new PhpLoader($path, $routed));
        Config::load('dummy');
        $this->assertEquals(1024, Config::get('dummy', 'upload_max_width'));
    }

    /**
     * @throws ConfException
     * @throws PathsException
     */
    public function testGetNoFile(): void
    {
        $path = new Path();
        $path->setDocumentRoot(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data');
        $routed = new RoutedPath(new routeSource\Arrays([]));
        Config::init(new PhpLoader($path, $routed));
        Config::load('unknown');
        $this->assertEquals('**really-not-existing', Config::get('**not-important', '**not-important', '**really-not-existing'));
    }

    /**
     * @throws ConfException
     */
    public function testMultiLoader(): void
    {
        $lib = new MultiLoader();
        $this->assertEmpty($lib->load('dummy', 'none'));
        $lib->addLoader(new XYLoader());
        $set = $lib->load('dummy', 'after loaded');
        $this->assertEquals(['abc' => 'mno', 'jkl' => 'vwx%s', ], $set);
    }

    /**
     * @throws ConfException
     */
    public function testClassLoader(): void
    {
        $lib = new ClassLoader();
        $this->assertEmpty($lib->load('not set', 'none'));
        $lib->addClass(new XYConf());
        $this->assertEmpty($lib->load('still not set', 'none'));
        $this->assertEquals(['abc01' => '98mno', 'jkl67' => '32vwx%s', ], $lib->load('testing', 'ignore now'));
    }
}


class XYLoader implements ILoader
{
    public function load(string $module, string $conf = ''): array
    {
        return [
            'abc' => 'mno',
            'jkl' => 'vwx%s',
        ];
    }
}


class XYConf implements IConf
{
    public function setPart(string $part): void
    {
        // nothing
    }

    public function getConfName(): string
    {
        return 'testing';
    }

    public function getSettings(): array
    {
        return [
            'abc01' => '98mno',
            'jkl67' => '32vwx%s',
        ];
    }
}
