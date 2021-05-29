# kw_confs

Define used configurations inside the KWCMS tree. Parse them and return them.

## PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_confs": "1.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)

This package contains example file from KWCMS bootstrap. Use it as reference.

This config bootstrap is connected with KWCMS modules. Using it outside KWCMS means
you need to know the tree structure of module system and positioning configs there.

The basic config itself is simple php file with defined array variable "$config" in
which are stored key-value pairs like in normal php array. You do not need to specify
module - it will be automatically set into content array when config loads.

It's also possible to use your own loader which will read your config files by your own
rules. So you can connect reading configurations from DB or INI file and that all will
still behave the same way. Just it's need to respect that loader's input is module and
sometimes conf name and output is array of key-value pairs which will be set into config
array with module as primary key.
