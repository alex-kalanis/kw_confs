<?php

namespace kalanis\kw_confs\Interfaces;


use kalanis\kw_confs\Exception;


/**
 * Class ILoader
 * @package kalanis\kw_confs\Interfaces
 * Load config data from defined source
 */
interface ILoader
{
    /**
     * @param string $module which module it will be looked for
     * @param string $conf which conf name will be looked for
     * @return string[] config array
     * @throws Exception
     */
    public function load(string $module, string $conf = ''): array;
}
