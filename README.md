Symfony Uecode Common Bundle
============

This bundle creates a simple way to incorporate Underground Elephant base code into Symfony

## Installation

1. Add to composer.json under `require`

```
"uecode/common-bundle": "1.0.0",
```

2. Register in `AppKernel`

``` php
	$bundles = array(
	// ...
	new Uecode\Bundle\CommonBundle\UecodeCommonBundle
```

3. Make sure, if you are using a user entity, it implements `Uecode\Bundle\CommonBundle\Model\UserInterface`

4. In config.yml, define your entity class, and your id property

```yml

uecode_common:
    services:
        user:
           entity: \Acme\DemoBundle\Entity\User
           id_property: id

```

5. From here, you can have your controller extend `Uecode\Bundle\CommonBundle\Controller\Controller`

6. You can also hook into the events that are defined in [`Uecode\Bundle\CommonBundle\UecodeCommonEvents`](Uecode\Bundle\CommonBundle\UecodeCommonEvents.php)


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/uecode/common-bundle/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

