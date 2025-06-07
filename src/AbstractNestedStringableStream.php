<?php


declare( strict_types = 1 );


namespace JDWX\Stream;


abstract class AbstractNestedStringableStream extends AbstractStringableStream {


    use NestedStreamableTrait;
}
