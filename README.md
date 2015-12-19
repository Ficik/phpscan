# PHP scanner

Very simple php scanner

## Requirements

- sane with sane-tools (`scanimage` executable in PATH)
- http user must be able to scan with scanimage (`usermod -aG scanner www-data`)

## Install

1. copy `config.ini.dist` to `config.ini`
2. run `composer install`
3. make public folder visible by your http server or run `php -S localhost:8080` in the public dir  
