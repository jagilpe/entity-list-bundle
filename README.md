EntityListBundle
====

EntityListBundle is a Symfony Bundle for for building and rendering lists of entities.

# Installation

You can install the bundle using composer:

```bash
composer require jagilpe/entity-list-bundle
```

or add the package to your composer.json file directly.

To enable the bundle, you just have to register the bundle in your AppKernel.php file:

```php
// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new Jagilpe\EntityListBundle\JagilpeEntityListBundle(),
    // ...
);
```

Finally you have to include the provided javascript file somewhere in your base template. 
If you use assetic to manage the assets:

```twig
{% block javascripts %}
    {{ parent() }}
    {% javascripts
        'bundles/jagilpeentitylist/js/jgp-searchable-table.js' %}
        <script src="{{ asset_url }}"></script>
    {% endjavascripts %}
{% endblock %}
```
This javascript depends on jQuery, List.js (>=1.5.0). Please refer to jQuery and List.js documentation
for instructions on how to enable it in your project.

http://listjs.com/

# Documentation

You can read the documentation of the usage of the bundle [here](Resources/doc/index.md)

You can also see a demo of this bundle in https://demos.gilpereda.com/symfony-bundles/entity-list/ or directly download the
demo from https://github.com/jagilpe/bundles-demo

# API Reference

https://api.gilpereda.com/entity-list-bundle/master/