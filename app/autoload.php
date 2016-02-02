<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

<<<<<<< HEAD
error_reporting(error_reporting() & ~E_USER_DEPRECATED);

=======
>>>>>>> abedb3fc2114b77e4ce5c8c9b7534d89a80d56ef
/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
