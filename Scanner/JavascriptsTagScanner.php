<?php

namespace Archfizz\ShakeDatAsseticBundle\Scanner;

use Archfizz\ShakeDatAsseticBundle\Scanner;
use Assetic\Extension\Twig\AsseticExtension;
use Assetic\Extension\Twig\AsseticTokenParser;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\VarDumper\VarDumper;

class JavascriptsTagScanner implements Scanner
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var AsseticExtension
     */
    private $asseticExtension;

    /**
     * @param \Twig_Environment $twig
     * @param AsseticExtension  $asseticExtension
     */
    public function __construct(\Twig_Environment $twig, AsseticExtension $asseticExtension = null)
    {
        $this->twig = $twig;
        $this->asseticExtension = $asseticExtension;
    }

    /**
     * {@inheritdoc}
     */
    public function scan(\SplFileInfo $file)
    {
        $template = file_get_contents($file->getPathname());

        $stream = $this->twig->tokenize($template);
        $lexerStream = clone $stream;

        $hasTag = false;

        while (! $stream->isEOF()) {
            $token = $stream->getCurrent();

            if (false !== strpos($token, 'NAME_TYPE(javascripts)')) {
                $hasTag = true;

                break;
            }

            $stream->next();
        }

        if (!$hasTag) {
            return;
        }

        unset($stream);

        $module = $this->twig->parse($lexerStream);

        $x = 0;

        foreach ($module as $node) {
            ++$x;
        }

        // Symfony\Bundle\AsseticBundle\Twig\AsseticNode

        VarDumper::dump($x);

//        /** @var AsseticTokenParser $parser */
//        foreach ($this->asseticExtension->getTokenParsers() as $parser) {
//            if ('javascripts' === $parser->getTag()) {
//                while (!$stream->isEOF()) {
//                    $node = $parser->parse($stream->getCurrent());
//
//                    $stream->next();
//                }
//            }
//        }
    }

}