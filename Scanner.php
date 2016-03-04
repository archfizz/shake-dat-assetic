<?php

namespace Archfizz\ShakeDatAsseticBundle;

interface Scanner
{
    public function scan(\SplFileInfo $file);
}
