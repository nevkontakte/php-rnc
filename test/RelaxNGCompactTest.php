<?php

namespace Nevkontakte\Phprnc\Test;

require_once __DIR__ . '/../vendor/autoload.php';

use Nevkontakte\Phprnc\RelaxNGCompact;

class RelaxNGCompactTest extends \PHPUnit_Framework_TestCase {

    public function testKeyword()
    {
        $parser = new RelaxNGCompact();
        $parser->parse('default');
        $parser->parse('"blablabla"');
        $parser->parse('"blablabla" ~ "ololo"');
        $parser->parse('testIdentifier123');
        $parser->parse('testIdentifier123:*');
        $parser->parse('testIdentifier123:something');
//        $this->assertEquals('identifier', $parser->parse('testIdentifier'));
//        $this->assertEquals('keyword', $parser->parse('default'));
        $this->assertEquals('NameClass', $parser->parse("(qwe)"));
        $this->assertEquals('NameClass', $parser->parse("(qwe|qwe)"));
        // This case causes infinite recursion
        $this->assertEquals('NameClass', $parser->parse("((qwe|asd)|qwe)"));
        $this->assertEquals('NameClass', $parser->parse("qwe|qwe"));
        $this->assertEquals('NameClass', $parser->parse("qwe"));
    }
}
