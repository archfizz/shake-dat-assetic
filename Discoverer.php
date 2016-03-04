<?php

namespace Archfizz\ShakeDatAsseticBundle;

interface Discoverer
{
    /**
     * @return \Generator|\SplFileInfo[]
     */
    public function searchForTemplates();
}
