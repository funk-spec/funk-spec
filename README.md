
Funk-Spec
=========


## What ?

A functional/system/integration test framework based on Behat/Testwork.

## Why ?

User acceptance tests shouldn't include technical details,  
but it doesn't mean some technical parts of the app shouldn't be independantly tested.

Moreover, some intermediate modules could be tested, standing between unit and system testing.

## How ?

``` bash

vim funk/Feature/That/DoesStuff/ProfitsTo/Customer.php
vendor/bin/funk funk
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

![img](https://raw.githubusercontent.com/funk-spec/funk-spec/master/funk.png)
