# jdwx/stream-php

A simple PHP module for handling arbitrarily large data streams.

## Installation

You can require it with Composer:

```bash
composer require jdwx/stream
```

Or download the source from GitHub: https://github.com/jdwx/stream-php.git

## Requirements

This module requires PHP 8.3 or later. It has no other dependencies.

## Usage

This module is designed to allow returning arbitrarily large amounts of data:
* without requiring the data to be held all in memory at the same time, and 
* without requiring all the data to be available before the initial data is returned.

This is useful, for example, for extremely large web pages or for web pages that take a long time to load to allow returning progressive updates. In smaller projects, it can also make it easier to combine smaller elements into a single output and can make it easier to post-process output or insert things at various points.

Specifically, if you have a stream like (using array notation):

[ 'Foo', $bar, 'Baz' ]

Where `$bar` is a Stringable object, the stream maintains `$bar` as an object reference. So if you then go to append `$qux` to the stream and determine that `$bar` needs to be modified, you can do that up until it has been consumed.

A smattering of tools for mocking and consuming such streams are also included, mostly for testing purposes.

## Stability

This module has complete test coverage. It is relatively new but has been widely used internally with good results and is believed stable.

The interface should be relatively stable at this point.

## History

This module was refactored out of a prerelease version of jdwx/web to separate concerns in June 2025.
