<?php

namespace voku\twig;

use Twig\Compiler;
use Twig\Node\Node;

class MinifyHtmlNode extends Node
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

    /**
     * @param Compiler $compiler
     */
    public function compile(Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write("ob_start();\n")
            ->subcompile($this->getNode('body'))
            ->write('$extension = $this->env->getExtension(\'\\voku\\twig\\MinifyHtmlExtension\');' . "\n")
            ->write('echo $extension->compress($this->env, ob_get_clean());' . "\n");
    }
}
