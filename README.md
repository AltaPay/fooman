# Fooman extension with Altapay integration

This extension enables compatibility between the fooman module and the Altapay extension.

## Compatibility
- Magento 2.3 and above

## Installation
Before installing this module, ensure that you have installed the Fooman OrderFee extension, which is officially provided by https://fooman.com/magento-extension-order-fees-m2.html

Run the following commands in Magento 2 root folder:

    composer require altapay/magento2-fooman
    php bin/magento setup:upgrade
    php bin/magento setup:di:compile
    php bin/magento setup:static-content:deploy
 
## Changelog

See [Changelog](CHANGELOG.md) for all the release notes.

## License

Distributed under the MIT License. See [LICENSE](LICENSE) for more information.
