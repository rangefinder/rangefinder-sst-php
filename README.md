## Rangefinder Server-Side Tracking for PHP

[Rangefinder](http://rangefinderapp.com/)'s server-side tracking allows you to record basic visitor information for every visitor, even those who block Rangefinder's client-side JavaScript. The client-side analytics fills in extra details, such as screen dimensions and page title, when/if it runs.

## Installation

This library is designed to run on PHP 5.3 or newer. However, it should work with older versions with one minor change.

### With Composer

Simply require `dirk/rangefinder-sst` in your composer.json.

### Basic installation

Download the [latest version of the tracking library](https://raw.github.com/rangefinder/rangefinder-sst-php/master/src/Rangefinder/Track1.php) (it's just a single file) and upload it to your server. Then you can just require it in your code:

```php
require_once 'path/to/Track1.php';
```

## Usage

The server-side tracking runs in two parts. First is sends off a tiny UDP packet to Rangefinder with the basic visit information, then it provides the &lt;script&gt; tag with the ID of that packet.

```php
// Early in your code
Rangefinder\Track1::$clientKey  = SERVER-SIDE TRACKING KEY;
Rangefinder\Track1::$clientSite = SITE ID;
Rangefinder\Track1::track();
// Right before the </body>
Rangefinder\Track1::code()
```

## License

Licensed under the New BSD License. See LICENSE for details.
