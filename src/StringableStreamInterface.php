<?php


declare( strict_types = 1 );


namespace JDWX\Stream;


use Stringable;


interface StringableStreamInterface extends StreamInterface, Stringable {


    /** @return iterable<string> */
    public function streamStrings() : iterable;


}