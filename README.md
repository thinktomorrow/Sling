# sling

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is an basic wrapper around the Laravel Mailer and provides a chainable api for constructing a mail message.
Please note that this package is in development and no stable version has been reached so far.

## Install

Via Composer

``` bash
$ composer require thinktomorrow/sling
```

## Usage

``` php
$sling->to('user@example.com','Ben Cavens')
     ->from('user@example.com','Ben Cavens')
     ->subject('This is a mail for you!')
     ->template('mails.invite') // blade view
     ->data(['name' => 'Ben Cavens']) // parameters for view
     ->send();
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email cavensben@gmail.com instead of using the issue tracker.

## Credits

- [bencavens][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/thinktomorrow/sling.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/thinktomorrow/sling/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/thinktomorrow/sling.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/thinktomorrow/sling.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/thinktomorrow/sling.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/thinktomorrow/sling
[link-travis]: https://travis-ci.org/thinktomorrow/sling
[link-scrutinizer]: https://scrutinizer-ci.com/g/thinktomorrow/sling/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/thinktomorrow/sling
[link-downloads]: https://packagist.org/packages/thinktomorrow/sling
[link-author]: https://github.com/bencavens
[link-contributors]: ../../contributors
