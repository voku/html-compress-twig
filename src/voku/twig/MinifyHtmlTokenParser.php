<?php

namespace voku\twig;

use Twig_Token;
use Twig_TokenParser;

/**
 * Class MinifyHtmlTokenParser
 *
 * @copyright Copyright (c) 2015 Marcel Voigt <mv@noch.so>
 * @copyright Copyright (c) 2017 Lars Moelleken <lars@moelleken.org>
 */
class MinifyHtmlTokenParser extends Twig_TokenParser
{
  /**
   * @param Twig_Token $token
   *
   * @return bool
   */
  public function decideHtmlCompressEnd(Twig_Token $token)
  {
    return $token->test('endhtmlcompress');
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  public function getTag()
  {
    return 'htmlcompress';
  }

  /**
   * @param Twig_Token $token
   *
   * @return MinifyHtmlNode
   */
  public function parse(Twig_Token $token)
  {
    $lineNumber = $token->getLine();
    $stream = $this->parser->getStream();
    $stream->expect(Twig_Token::BLOCK_END_TYPE);
    $body = $this->parser->subparse(array($this, 'decideHtmlCompressEnd'), true);
    $stream->expect(Twig_Token::BLOCK_END_TYPE);
    $nodes = array('body' => $body);

    return new MinifyHtmlNode($nodes, array(), $lineNumber, $this->getTag());
  }
}
