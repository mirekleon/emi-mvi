<?php

namespace MVI\Component\Parser;

use MVI\Component\Parser\Parser;
use MVI\Component\Parser\ParserInterface;

/**
 *
 */
class ConstantParser extends Parser implements ParserInterface
{
    /**
     *
     */
    public function get()
    {
        $ready = [];
        $content = $this->getContent();
        foreach ($content as $line) {
            if (preg_match('/^(public\s+)?const\s+(.*?)\s+/', trim($line), $constants)) {
                $ready[] = trim($constants[2]) ?? null;
            }
        }
        return array_filter($ready);
    }
}
