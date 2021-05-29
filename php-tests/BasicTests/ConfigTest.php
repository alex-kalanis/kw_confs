<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_confs\Config;
use kalanis\kw_confs\Interfaces\ILoader;
use kalanis\kw_paths\Path;


class ConfigTest extends CommonTestClass
{
    public function testBasic(): void
    {
        $path = new Path();
        $path->setDocumentRoot('/tmp/none');
        Config::init($path);
        Config::init($path, new XLoader());
        Config::load('baz');

        $xPath = Config::getPath();
        $xPath->setPathToSystemRoot('sdfgsdfgt/');
        $this->assertNotEquals(Config::getOriginalPath(), $xPath);

        $this->assertEquals('pqr', Config::get('baz','def'));
        $this->assertEquals('lkj', Config::get('baz','ewq', 'lkj'));
        $this->assertEquals('vwx%s', Config::get('baz','jkl', '123'));
        $this->assertEquals('123', Config::get('baz','asdf%s', '123'));
    }
}


class XLoader implements ILoader
{
    public function load(string $module, string $conf = ''): array
    {
        return [
            'abc' => 'mno',
            'def' => 'pqr',
            'ghi' => 'stu',
            'jkl' => 'vwx%s',
        ];
    }
}
