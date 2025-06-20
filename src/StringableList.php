<?php


declare( strict_types = 1 );


namespace JDWX\Stream;


use Stringable;


class StringableList implements StringableListInterface, StringableStreamInterface {


    use StringableListTrait;
    use StringableStreamTrait;


    /**
     * @param iterable<int|string, string|Stringable>|string|Stringable $i_children
     * @noinspection PhpDocSignatureInspection
     */
    public function __construct( iterable|string|Stringable $i_children = [] ) {
        $this->append( $i_children );
    }


    /** @return iterable<int|string, string|Stringable> */
    public function stream() : iterable {
        yield from $this->children();
    }


}
