# Changelog

All notable changes to `redsnapper/socialite-swissrx` will be documented in this file.

## 2.0.0

### Changed

- **BREAKING**: Upgraded `firebase/php-jwt` from `^6.4` to `^7.0` to resolve CVE-2025-45769 (weak encryption). The `client_secret` must now be at least 32 bytes long for HS256. Older 9-character secrets are no longer supported.
- Removed legacy code path that repeated 9-character secrets for JWT decoding. This was incompatible with php-jwt v7's minimum key length enforcement.
- Fixed typo in `composer.json` (`authosr` -> `authors`).

## 1.0.0 - 2021-08-25

- initial release
