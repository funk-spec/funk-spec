<?php

namespace Funk\Autoloader\ServiceContainer;

use Behat\Testwork\Autoloader\ServiceContainer\AutoloaderExtension as BaseExtension;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class AutoloaderExtension extends BaseExtension
{
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->beforeNormalization()
            ->ifString()
            ->then(function($path) {
                    return array('' => $path);
                })
            ->end()
            ->defaultValue(array('' => '%paths.base%/funk'))
            ->treatTrueLike(array('' => '%paths.base%/funk'))
            ->treatNullLike(array('' => '%paths.base%/funk'))
            ->treatFalseLike(array())
            ->prototype('scalar')->end()
        ;
    }
}
