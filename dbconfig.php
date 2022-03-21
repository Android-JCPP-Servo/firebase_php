<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth;

$factory = (new Factory)
->withServiceAccount('phpcyberlandr-firebase-adminsdk-m9hpe-cce2c1917d.json')
->withDatabaseUri('https://phpcyberlandr-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();

?>