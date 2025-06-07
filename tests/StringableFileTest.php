<?php


declare( strict_types = 1 );


namespace JDWX\Stream\Tests;


use JDWX\Stream\StringableFile;
use PHPUnit\Framework\TestCase;


class StringableFileTest extends TestCase {


    public function testToString() : void {
        $stf = new StringableFile( __DIR__ . '/data/test.txt' );
        self::assertSame( 'FOO_BAR', strval( $stf ) );

        $stf = new StringableFile( __DIR__ . '/data/no-such-file.txt' );
        self::expectException( \RuntimeException::class );
        $stf->__toString();
    }


}
