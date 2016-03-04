<?php

namespace Archfizz\ShakeDatAsseticBundle\Discoverer;

use Archfizz\ShakeDatAsseticBundle\Discoverer;
use Symfony\Component\Finder\Finder;

/**
 * @todo rename as Discoverer?
 */
class SymfonyStandardTemplateDiscoverer implements Discoverer
{
    /**
     * @var string
     */
    private $appDir;

    /**
     * @var string
     */
    private $srcDir;

    /**
     * @param string $appDir
     * @param string $srcDir
     */
    public function __construct($appDir, $srcDir)
    {
        $this->appDir = $appDir;
        $this->srcDir = $srcDir;
    }

    /**
     * @return \Generator|\SplFileInfo[]
     *
     * @throws \InvalidArgumentException
     */
    public function searchForTemplates()
    {
        $appFinder = new Finder();
        $appFinder->files()
            ->in([
                $this->appDir.'/Resources',
            ])
            ->path('views')
        ;

        /** @var \SplFileInfo $file */
        foreach ($appFinder as $file) {
            if (false !== strpos($file->getFilename(), '.html.twig')) {
                yield $file;

                continue;
            }
        }

        $srcFinder = new Finder();
        $srcFinder->files()
            ->in([
                $this->srcDir,
            ])
            ->path('Resources/views')
        ;

        foreach ($srcFinder as $file) {
            if (false !== strpos($file->getFilename(), '.html.twig')) {
                yield $file;

                continue;
            }
        }
    }
}
