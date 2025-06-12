<?php


declare( strict_types = 1 );


namespace JDWX\Stream;


use Stringable;


trait NestedStreamableTrait {


    /** @return iterable<int|string, string|Stringable> */
    public function stream() : iterable {
        yield from StreamHelper::yield( $this->prefix() );
        yield from StreamHelper::yield( $this->infix() );
        yield from StreamHelper::yield( $this->postfix() );
    }


    /** @return iterable<int|string, string|Stringable>|string|Stringable */
    abstract protected function infix() : iterable|string|Stringable;


    /** @return iterable<int|string, string|Stringable>|string|Stringable */
    abstract protected function postfix() : iterable|string|Stringable;


    /** @return iterable<int|string, string|Stringable>|string|Stringable */
    abstract protected function prefix() : iterable|string|Stringable;


}
