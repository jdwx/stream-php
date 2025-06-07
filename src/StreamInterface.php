<?php


declare( strict_types = 1 );


namespace JDWX\Stream;


use Stringable;


/**
 * @suppress PhanAccessWrongInheritanceCategoryInternal
 */
interface StreamInterface {


    /** @return list<string|Stringable> */
    public function asList() : array;


    /** @return iterable<string|Stringable> */
    public function stream() : iterable;


}