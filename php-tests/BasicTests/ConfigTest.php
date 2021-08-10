<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_confs\Config;
use kalanis\kw_confs\Interfaces\IConf;
use kalanis\kw_confs\Interfaces\ILoader;
use kalanis\kw_input\Input;
use kalanis\kw_paths\Path;


class ConfigTest extends CommonTestClass
{
    public function testInput(): void
    {
        // just for debug - this one works elsewhere
        $input = new Input([]);
        $input->offsetSet('abc', 'def');
        $input->offsetGet('abc');
    }

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

        $this->assertInstanceOf('\kalanis\kw_confs\Interfaces\ILoader', Config::getLoader());
    }

    public function testClass(): void
    {
        $path = new Path();
        $path->setDocumentRoot('/tmp/none');
        Config::init($path, new XLoader());
        Config::loadClass(new XConf());

        $this->assertEquals('76pqr', Config::get('testing','def23'));
        $this->assertEquals('lkj', Config::get('testing','ewq', 'lkj'));
        $this->assertEquals('32vwx%s', Config::get('testing','jkl67', '123'));
        $this->assertEquals('123', Config::get('testing','asdf%s', '123'));
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


class XConf implements IConf
{
    public function getConfName(): string
    {
        return 'testing';
    }

    public function getSettings(): array
    {
        return [
            'abc01' => '98mno',
            'def23' => '76pqr',
            'ghi45' => '54stu',
            'jkl67' => '32vwx%s',
        ];
    }
}
