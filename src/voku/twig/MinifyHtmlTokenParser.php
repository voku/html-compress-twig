<?php

declare(strict_types=1);

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
  public function decideHtmlCompressEnd(Twig_Token $token): bool
  {
    return $token->test('endhtmlcompress');
  }

  /** @noinspection PhpMissingParentCallCommonInspection */
  public function getTag(): string
  {
    return 'htmlcompress';
  }

  /**
   * @param Twig_Token $token
   *
   * @return MinifyHtmlNode
   */
  public function parse(Twig_Token $token): MinifyHtmlNode
  {
    $lineNumber = $token->getLine();
    $stream = $this->parser->getStream();
    $stream->expect(Twig_Token::BLOCK_END_TYPE);
    $body = $this->parser->subparse([$this, 'decideHtmlCompressEnd'], true);
    $stream->expect(Twig_Token::BLOCK_END_TYPE);
    $nodes = ['body' => $body];

    return new MinifyHtmlNode($nodes, [], $lineNumber, $this->getTag());
  }
}
