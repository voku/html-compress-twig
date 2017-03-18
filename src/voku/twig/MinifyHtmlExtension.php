<?php

namespace voku\twig;

use Twig_Environment;
use voku\helper\HtmlMin;

/**
 * Class MinifyHtmlExtension
 *
 * @copyright Copyright (c) 2015 Marcel Voigt <mv@noch.so>
 * @copyright Copyright (c) 2017 Lars Moelleken <lars@moelleken.org>
 */
class MinifyHtmlExtension extends \Twig_Extension
{
  /**
   * @var array
   */
  private $options = array(
      'is_safe'           => array('html'),
      'needs_environment' => true,
  );

  /**
   * @var callable
   */
  private $callable;

  /**
   * @var HtmlMin
   */
  private $minifier;

  /**
   * @var bool
   */
  private $forceCompression = false;

  /**
   * MinifyHtmlExtension constructor.
   *
   * @param HtmlMin $htmlMin
   * @param bool    $forceCompression Default: false. Forces compression regardless of Twig's debug setting.
   */
  public function __construct(HtmlMin $htmlMin, $forceCompression = false)
  {
    $this->forceCompression = $forceCompression;
    $this->minifier = new HtmlMin();
    $this->callable = array($this, 'compress');
  }

  /**
   * @param Twig_Environment $twig
   * @param                  $html
   *
   * @return mixed
   */
  public function compress(Twig_Environment $twig, $html)
  {
    if (!$twig->isDebug() || $this->forceCompression) {
      return $this->minifier->minify($html);
    }

    return $html;
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  /**
   * @return array
   */
  public function getFilters()
  {
    return array(
        new \Twig_SimpleFilter('htmlcompress', $this->callable, $this->options),
    );
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  public function getFunctions()
  {
    return array(
        new \Twig_SimpleFunction('htmlcompress', $this->callable, $this->options),
    );
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  public function getTokenParsers()
  {
    return array(
        new MinifyHtmlTokenParser(),
    );
  }
}
