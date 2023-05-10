# kw_confs

[![Build Status](https://app.travis-ci.com/alex-kalanis/kw_confs.svg?branch=master)](https://app.travis-ci.com/github/alex-kalanis/kw_confs)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_confs/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_confs/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_confs/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_confs)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_confs.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_confs)
[![License](https://poser.pugx.org/alex-kalanis/kw_confs/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_confs)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_confs/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_confs/?branch=master)

Define used configurations inside the KWCMS tree. Parse them and return them.

## PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_confs": "2.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)

This package contains example file from KWCMS bootstrap. Use it as reference.

This config bootstrap is connected with KWCMS modules. Using it outside KWCMS means
you need to know the tree structure of module system and positioning configs there.

The idea is about configs which are separated not just by their name (single namespace)
but also with their module name - so you can use the same key in more modules with
a bit different meanings.

The basic config itself is simple php file with defined array variable "$config" in
which are stored key-value pairs like in normal php array. You need to specify
module - it will be automatically set there into content array when config loads.

It's also possible to use your own loader which will read your config files by your own
rules. So you can connect reading configurations from DB or INI file and that all will
still behave the same way. Just it's need to respect that loader's input is module and
sometimes conf name and output is array of key-value pairs which will be set into config
array with module as primary key.

#### Examples:

For module 'image as part of content' there came array ['your internal config key' =>
'this value will be get', 'another key' => false, ]

```php
print \kalanis\kw_confs\Config::get('image as part of content', 'your internal system key', 'dummy');
```

And it returns 'dummy'

```php
print \kalanis\kw_confs\Config::get('image as part of content', 'your internal config key', 'nope');
```

And it returns 'this value will be get'

The best usage is inside the controller classes across the other modules - you just fill
 ```Config::get()``` with your keys. It is possible to make a whole class which returns
 the wanted configs which will be instance of ```IConf``` and then pass it into lang loader.
