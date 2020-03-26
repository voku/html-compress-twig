<?php

use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use voku\helper\HtmlMin;
use voku\twig\MinifyHtmlExtension;

/**
 * Class ExtensionTest
 *
 * @internal
 */
final class ExtensionTest extends TestCase
{
    /**
     * @return array
     */
    public function htmlProvider()
    {
        $original = '<html> <p> x  x </p> </html>';
        $compressed = '<html><p> x x';

        $testData = [];
        $testMethods = [
            'Twig tag'      => '{% htmlcompress %}%s{% endhtmlcompress %}',
            'Twig function' => "{{ htmlcompress('%s') }}",
            'Twig filter'   => "{{ '%s' | htmlcompress }}",
        ];

        foreach ($testMethods as $testMethod => $testTemplate) {
            $testData[$testMethod] = [
                \str_replace('%s', $original, $testTemplate),
                $original,
                $compressed,
            ];
        }

        return $testData;
    }

    /**
     * @dataProvider htmlProvider
     *
     * @param $template
     * @param $original
     * @param $compressed
     */
    public function testExtensionMethod($template, $original, $compressed)
    {
        $loader = new Twig\Loader\ArrayLoader(['test' => $template]);
        $twig = new Environment($loader);
        $minifier = new HtmlMin();
        $twig->addExtension(new MinifyHtmlExtension($minifier));
        static::assertEquals($compressed, $twig->render('test'));
    }

    /**
     * @dataProvider htmlProvider
     *
     * @param $template
     * @param $original
     * @param $compressed
     */
    public function testForceCompressionWhenDebug($template, $original, $compressed)
    {
        $loader = new ArrayLoader(['test' => $template]);
        $twig = new Environment($loader, ['debug' => true]);
        $minifier = new HtmlMin();
        $twig->addExtension(new MinifyHtmlExtension($minifier, true));

        // Assert that compression took place
        static::assertEquals($compressed, $twig->render('test'));
    }

    /**
     * @dataProvider htmlProvider
     *
     * @param $template
     * @param $original
     * @param $compressed
     */
    public function testNoCompressionWhenDebug($template, $original, $compressed)
    {
        $loader = new ArrayLoader(['test' => $template]);
        $twig = new Environment($loader, ['debug' => true]);
        $minifier = new HtmlMin();
        $twig->addExtension(new MinifyHtmlExtension($minifier));

        // Assert no compression took place
        static::assertEquals($original, $twig->render('test'));
    }
}
