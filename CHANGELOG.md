# Changelog

## v2.1.1 (21. Mar 2022)

Bug Fixes:
- Fixed the post body deserialization. Billbee sends the payload as `x-www-form-urlencoded`, not a json body.
- Fixed the UnitTests
- Removed the `\Throwable` usage to support PHP 5.6.
- Using `NewStateTypeId` instead of `NewStateId` when updating the order state. `NewStateTypeId` contains an int,
  `NewStateId` a string.

## v2.1.0 (11. Feb 2022)

Updated:
- Version constraints for PHP and jms/serializer updated

## v2.0.0 (25. Jun 2021)

Added:
- `Order::$deliverySourceCountryCode`.

Bug Fixes:
- Renamed `Order::$countryCode` to `Order::$currencyCode` (breaking)
- Fixed the unit tests
- Fix method ackOrder - change url arguments to post body ([PR #1](https://github.com/billbeeio/custom-shop-php-sdk/pull/1))

## v1.0.1 (2. Sept. 2019)
- Removed `ext-xdebug` from `composer.json`
- Changelog added

## v1.0.0 (1. Sept. 2019)
Initial Release
