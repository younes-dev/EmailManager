
>###  install PHPCS Via Composer
```
composer global require "squizlabs/php_codesniffer=*"
```

>###  install via composer.json
```
1. Add this script in composer.json
{
    "require-dev": {
        "squizlabs/php_codesniffer": "3.*"
    }
}

2) composer update
```
>###  CMD
```
  Execute all Errors By   :   ./vendor/bin/phpcs -h
  Execute all Errors By   :   ./vendor/bin/phpcs /application/src/ --colors
```

>###  Tutorials

- [How to use PHP CodeSniffer](https://www.youtube.com/watch?v=tKih3UZuwXw)
