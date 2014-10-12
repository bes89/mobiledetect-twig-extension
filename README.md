mobiledetect-twig-extension
===========================

"Mobile Detect" integration for Twig


Installation
------------


```bash
    php composer.phar require "bes/mobiledetect-twig-extension:v1.0"
```

And register the extension:


**Twig standalone**

```php
    $twig->addExtension(new Bes\Twig\Extension\MobileDetectExtension());
```


**Silex**

Yay, you don't need a ServiceProvider for it!

Add the following code after registering TwigServiceProvider:

```php
    $app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
        /* @var $twig \Twig_Environment */
        $twig->addExtension(new Bes\Twig\Extension\MobileDetectExtension);
        return $twig;
    }));
```
... and you are done!


**Symfony2**

Yay, you don't need a Bundle for it!

Add the following code to one of your services.yml, e.g. `src/<vendor>/<your>Bundle/Resources/config/services.yml` or
globally in `app/config/config.yml`:

```yaml
    services:
        twig.mobile_detect_extension:
            class: Bes\Twig\Extension\MobileDetectExtension
            tags:
                - { name: twig.extension }```

... and you are done!


Examples
--------

Render different layouts:

```jinja
{% extends is_mobile() ? "layout_mobile.html.twig" : "layout.html.twig" %}
```

Check device type:

```jinja
{% if is_mobile() %} ... {% endif %}
{% if is_tablet() %} ... {% endif %}
```

Or:

```jinja
{% if is_mobile() and is_samsung() %} ... {% endif %}
```

You can get a list of all the known devices with:

```jinja
    {{ get_available_devices()|join("<br />")|raw }}
```