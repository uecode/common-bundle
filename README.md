Symfony Gearman Bundle
============

This bundle creates a simple way to incorporate Gearman into Symfony

## Installation

1. Add to composer.json under `require`

```
"uecode/gearman": "dev-master",
```

2. Register in `AppKernel`

``` php
	$bundles = array(
	// ...
	new Uecode\GearmanBundle\UecodeGearmanBundle