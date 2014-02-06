
Funk-Spec
=========


## What ?

A functional/system/integration test framework based on Behat/Testwork.

## Why ?

Because. And also to let people who don't need a DSL like gherkin write specs.

## How ?

``` bash

vim funk/Feature/That/DoesStuff/ProfitsTo/Customer.php
bin/funk funk
```


``` php

<?php

namespace funk\Feature\That\DoesStuff\ProfitsTo;

use Funk\Spec;

class Customer implements Spec
{
    function it_simplifies_customers_life()
    {
        // pic or it didn't happen!
    }
}

```

![img](https://raw2.github.com/docteurklein/funk-spec/master/funk.png)
