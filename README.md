mobiledetect-twig-extension
===========================

"Mobile Detect" integration for Twig


Installation
------------

Add this to your `composer.json` to the `require` section:

```json
    {
        "bes/mobiledetect-twig-extension": "dev-master"
    }
```

Then run:

`php composer.phar install`

And register the extension:

```php
    use Bes\Twig\Extension\MobileDetectExtension;

    // ...

    $twig->addExtension(new MobileDetectExtension());
```


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