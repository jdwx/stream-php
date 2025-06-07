<?php


declare( strict_types = 1 );


namespace JDWX\Stream;


readonly class StringableFile implements \Stringable {


    public function __construct( private string $stFilePath ) {
    }


    public function __toString() : string {
        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        $bst = @file_get_contents( $this->stFilePath );
        if ( false === $bst ) {
            throw new \RuntimeException( 'Unable to read file: ' . $this->stFilePath );
        }
        return $bst;
    }


}
