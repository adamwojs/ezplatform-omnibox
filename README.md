# ezplatform-omnibox

Omnibox search for Ibexa DXP (eZ Platform) backend.

## Installation

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require adamwojs/ezplatform-omnibox
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require adamwojs/ezplatform-omnibox
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    AdamWojs\EzPlatformOmnibox\EzPlatformOmniboxBundle::class => ['all' => true],
];
```

### Step 3: Import routes

Creating `ezplatform_omnibox.yaml` in `/config/routes/` directory and import `@EzPlatformOmniboxBundle/Resources/config/routing.yaml` 

```yaml
ezplatform_omnibox:
    resource: '@EzPlatformOmniboxBundle/Resources/config/routing.yaml'
    defaults:
        siteaccess_group_whitelist: '%admin_group_name%'
```

### Step 4: Switch `admin` to `omnibox` design

`ezplatform-omnibox` overwrites `top_navigation.html.twig` template, 
so you have to switch design from `admin` to `omnibox`. 

```yaml
ezplatform:
    system:
        admin:
            design: omnibox
```
