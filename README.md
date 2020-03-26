[![Build Status](https://travis-ci.org/voku/html-compress-twig.svg?branch=master)](https://travis-ci.org/voku/html-compress-twig)
[![Coverage Status](https://coveralls.io/repos/github/voku/html-compress-twig/badge.svg?branch=master)](https://coveralls.io/github/voku/html-compress-twig?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/voku/html-compress-twig/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/voku/html-compress-twig/?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/0497e1f5be2d43a08c0a108dc7192287)](https://www.codacy.com/app/voku/html-compress-twig?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=voku/html-compress-twig&amp;utm_campaign=Badge_Grade)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/40d6318a-64fc-4927-8438-c57b0f546949/mini.png)](https://insight.sensiolabs.com/projects/40d6318a-64fc-4927-8438-c57b0f546949)
[![Latest Stable Version](https://poser.pugx.org/voku/html-compress-twig/v/stable)](https://packagist.org/packages/voku/html-compress-twig) 
[![Total Downloads](https://poser.pugx.org/voku/html-compress-twig/downloads)](https://packagist.org/packages/voku/html-compress-twig) 
[![Latest Unstable Version](https://poser.pugx.org/voku/html-compress-twig/v/unstable)](https://packagist.org/packages/voku/html-compress-twig)
[![License](https://poser.pugx.org/voku/html-compress-twig/license)](https://packagist.org/packages/voku/html-compress-twig)

# :clamp: HtmlMin for Twig: HTML Compressor and Minifier

## Description

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

$twig = new \Twig\Environment($loader);
$minifier = new HtmlMin();
$twig->addExtension(new MinifyHtmlExtension($minifier));
```

### Register extension in symfony 4
Specifying HtmlMin is needed for the autowiring.

```yaml
    voku\helper\HtmlMin:
        tags:
            - { name: HtmlMin }

    voku\twig\MinifyHtmlExtension:
        arguments:
            $forceCompression: false
        tags:
            - { name: twig.extension }
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
