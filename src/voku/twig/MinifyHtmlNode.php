<?php

namespace voku\twig;

use Twig_Node;

/**
 * Class MinifyHtmlNode
 *
 * @copyright Copyright (c) 2015 Marcel Voigt <mv@noch.so>
 * @copyright Copyright (c) 2017 Lars Moelleken <lars@moelleken.org>
 */
class MinifyHtmlNode extends Twig_Node
{
  /**
   * MinifyHtmlNode constructor.
   *
   * @param array $nodes
   * @param array $attributes
   * @param int   $lineno
   * @param null  $tag
   */
  public function __construct(array $nodes = [], array $attributes = [], $lineno = 0, $tag = null)
  {
    parent::__construct($nodes, $attributes, $lineno, $tag);
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  /**
   * @param \Twig_Compiler $compiler
   */
  public function compile(\Twig_Compiler $compiler)
  {
    $compiler
        ->addDebugInfo($this)
        ->write("ob_start();\n")
        ->subcompile($this->getNode('body'))
        ->write('$extension = $this->env->getExtension(\'\\voku\\twig\\MinifyHtmlExtension\');' . "\n")
        ->write('echo $extension->compress($this->env, ob_get_clean());' . "\n");
  }
}
