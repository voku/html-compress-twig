# voku/html-compress-twig extension

A [Twig](http://twig.sensiolabs.org/) extension for [voku/HtmlMin](https://github.com/voku/HtmlMin).

Currently supported Twig features are:

* Tag
    * `{% htmlcompress %} <foo>bar</foo> {% endhtmlcompress %}`
* Function
    * `{{ htmlcompress(' <foo>bar</foo>') }}`
* Filter
    * `{{ ' <foo>bar</foo>' | htmlcompress }}`

* [Installation](#installation)
* [Usage](#usage)
* [History](#history)
* [License](#license)

## Installation

1. Install and use [composer](https://getcomposer.org/doc/00-intro.md) in your project.
2. Require this package via composer:

```sh
composer require voku/html-compress-twig
```

## Usage

First register the extension with Twig:

```php
use voku\helper\HtmlMin;
use voku\twig\MinifyHtmlExtension;

$twig = new Twig_Environment($loader);
$minifier = new HtmlMin();
$twig->addExtension(new MinifyHtmlExtension($minifier));
```

Then use it in your templates:

```
{% htmlcompress %} <foo>bar</foo> {% endhtmlcompress %}
{{ htmlcompress(' <foo>bar</foo>') }}
{{ ' <foo>bar</foo>' | htmlcompress }}
```

**Compression is disabled by Twig's `debug` setting.** This is to make development easier, however you can always
override it.

The constructor of this extension takes a boolean as second parameter `$forceCompression`. When true, this will 
force compression regardless of Twig's `debug` setting. It defaults to false when omitted.

```php
$twig->addExtension(new MinifyHtmlExtension($minifier, true));
```

## History
See [CHANGELOG](CHANGELOG.md) for the full history of changes.

## License
This project is licensed under the ISC license which is MIT/GPL compatible and FSF/OSI approved.
See the [LICENSE](LICENSE) file for the full license text.
