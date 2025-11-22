<?php


declare( strict_types = 1 );


namespace JDWX\Stream;


use Psr\Log\LoggerInterface;
use Stringable;


/**
 * BasicStream iterable<int|string, string|Stringable>|string|Stringable
 * NestedStream iterable<int|string, string|Stringable|iterable<int|string, string|Stringable>|string|Stringable>|string|Stringable
 * InfiniteStream iterable<int|string, iterable<int|string, string|Stringable|iterable<int|string, string|Stringable>|string|Stringable>|string|Stringable>|string|Stringable
 *
 * NullableIterableStream iterable<int|string, string|Stringable|null>
 * NullableBasicStream iterable<int|string, iterable<int|string, string|Stringable|null>>|string|Stringable|null
 * NullableNestedStream iterable<int|string, iterable<int|string, iterable<int|string, string|Stringable|null>>|string|Stringable|null>|string|Stringable|null
 * NullableInfiniteStream iterable<int|string, iterable<int|string, iterable<int|string, iterable<int|string, string|Stringable|null>>|string|Stringable|null>|string|Stringable|null>|string|Stringable|null
 */
final class StreamHelper {


    /**
     * @param iterable<int|string, iterable<int|string, string|Stringable|iterable<int|string, string|Stringable>|string|Stringable>|string|Stringable>|string|Stringable $i_stream
     * @return list<string|Stringable>
     *
     * This differs from StreamInterface::asList() because it flattens the list all the
     * way down, whereas StreamInterface::asList() doesn't recurse into children that are
     * Stringable, which includes most streams.
     */
    public static function asList( iterable|string|Stringable $i_stream ) : array {
        return iterator_to_array( self::yieldDeep( $i_stream ), false );
    }


    /** @param iterable<int|string, iterable<int|string, string|Stringable|iterable<int|string, string|Stringable>|string|Stringable>|string|Stringable>|string|Stringable $i_stream */
    public static function toString( iterable|string|Stringable $i_stream ) : string {
        if ( is_string( $i_stream ) ) {
            return $i_stream;
        }
        if ( $i_stream instanceof Stringable ) {
            return $i_stream->__toString();
        }
        return implode( '', self::asList( $i_stream ) );
    }


    /**
     * @param iterable<int|string, string|Stringable>|string|Stringable $i_chunk
     * @return iterable<int|string, string|Stringable>
     */
    public static function yield( iterable|string|Stringable $i_chunk ) : iterable {
        if ( is_string( $i_chunk ) || $i_chunk instanceof Stringable ) {
            yield $i_chunk;
            return;
        }
        yield from $i_chunk;
    }


    /**
     * @param iterable<int|string, iterable<int|string, string|Stringable|iterable<int|string, string|Stringable>|string|Stringable>|string|Stringable>|string|Stringable $i_chunk
     * @return iterable<int|string, string|Stringable>
     */
    public static function yieldDeep( iterable|string|Stringable $i_chunk ) : iterable {
        if ( $i_chunk instanceof StreamInterface ) {
            $i_chunk = $i_chunk->stream();
        }
        if ( is_string( $i_chunk ) || ( $i_chunk instanceof Stringable && ! is_iterable( $i_chunk ) ) ) {
            yield $i_chunk;
            return;
        }
        foreach ( $i_chunk as $chunk ) {
            /** @phpstan-var iterable<int|string, string|Stringable|iterable<int|string, string|Stringable>|string|Stringable>|string|Stringable $chunk */
            yield from self::yieldDeep( $chunk );
        }
    }


    /**
     * @param iterable<int|string, iterable<int|string, string|Stringable|iterable<int|string, string|Stringable>|string|Stringable>|string|Stringable>|string|Stringable $i_chunk
     * @return iterable<int, string|Stringable>
     */
    public static function yieldDeepList( iterable|string|Stringable $i_chunk ) : iterable {
        if ( $i_chunk instanceof StreamInterface ) {
            $i_chunk = $i_chunk->stream();
        }
        if ( is_string( $i_chunk ) || ( $i_chunk instanceof Stringable && ! is_iterable( $i_chunk ) ) ) {
            yield $i_chunk;
            return;
        }
        foreach ( $i_chunk as $chunk ) {
            /** @phpstan-var iterable<int|string, string|Stringable|iterable<int|string, string|Stringable>|string|Stringable>|string|Stringable $chunk */
            yield from self::yieldDeepList( $chunk );
        }
    }


    /**
     * @param iterable<int|string, string|Stringable>|string|Stringable $i_chunk
     * @return iterable<int, string|Stringable>
     */
    public static function yieldList( iterable|string|Stringable $i_chunk, ?LoggerInterface $i_logger = null ) : iterable {
        if ( is_string( $i_chunk ) || ( $i_chunk instanceof Stringable && ! is_iterable( $i_chunk ) ) ) {
            yield $i_chunk;
            return;
        }
        foreach ( $i_chunk as $chunk ) {
            if ( is_string( $chunk ) || $chunk instanceof Stringable ) {
                yield $chunk;
            } elseif ( is_int( $chunk ) || is_float( $chunk ) ) {
                yield strval( $chunk );
            } elseif ( is_null( $chunk ) ) {
                $i_logger?->debug( 'Null chunk skipped' );
            } else {
                throw new \RuntimeException( 'Invalid chunk type: ' . get_debug_type( $chunk ) );
            }
        }
    }


}
