# Scandipwa_StoresGraphql

Magneto 2 Store related functionality extension

## What`s inside?

### Difference in `Store` header handling

> **THIS IS DEPRECATED!** This is done for backwards-compatibility.
> Please use Store header to set store in the future.

This module provides Magento 2.3.3 default functionality, which is:

In graphql scope Magento always prefers `Store` Header set in the request
 to determine the store. If none is passed, the Magento will default to `default` store,
 even if the `MAGE_RUN_CODE` env variable is set. This means that the application should be
 responsible for store switching - which is in our opinion right. Except, we prefer
 no setting the store to default if header not present.
 
 Which is exactly what this extension does - if no `Store` header is passed, we will default
 to `MAGE_RUN_CODE` store.
 
 The `Store` header support is coming with future versions of base-theme. Expected in `2.6.0`.
 
 ### All stores endpoint
 
 Basic endpoint to retrieve the store data about the store, is needed for store switcher render.
 