<?php

namespace Archfizz\ShakeDatAsseticBundle\Command;

use Archfizz\ShakeDatAsseticBundle\Discoverer\SymfonyStandardTemplateDiscoverer;
use Archfizz\ShakeDatAsseticBundle\Scanner\JavascriptsTagScanner;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GulpCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('shake-assetic-for:gulp');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $twig = $this->getContainer()->get('twig');

        $appDir = $this->getContainer()->getParameter('kernel.root_dir');
        $srcDir = $appDir . '/../src';

        $discoverer = new SymfonyStandardTemplateDiscoverer($appDir, $srcDir);

        $scanner = new JavascriptsTagScanner($twig);


        /** @var \SplFileInfo $dir */
        foreach ($discoverer->searchForTemplates() as $i => $file) {
            $scanner->scan($file);

            //if ($i > 6) break;

            // $output->writeln($file->getRealPath());
        }

        //$module = $twig->parse($stream);

        //\Symfony\Component\VarDumper\VarDumper::dump($appFinder);

        return 0;
    }
}
