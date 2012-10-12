Symfony Common Bundle
============

This bundle is the connector for the uecode

## Installation

1. Add to composer.json under `require`

```
"uecode/common": "dev-master",
```

2. Register in `AppKernel`

``` php
	$bundles = array(
	// ...
	new Uecode\CommonBundle\UecodeCommonBundle