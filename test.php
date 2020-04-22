<?php

require_once 'vendor/autoload.php';
use \wishlist\utils\ConnectionFactory;
use \wishlist\models\Item;
use \wishlist\models\Liste;
use \wishlist\models\User;

use wishlist\views\ListView;

ConnectionFactory::makeConnection('src/conf/conf.ini');

$no = 1;
$wichlists = Liste::getById($no);
echo $wichlists->titre;

$l = Liste::getByToken('nosecure2');
echo $l->titre;
echo "\n";

$tab = Liste::recupererTest();

$tab2 = array("titre"=>"test2","token"=>"secure1");
$tab3 = array("titre"=>"test2","description"=>"test test test");
$l2 = Liste::create($tab3);
$l2->updateListe($tab2);
$l2->deleteListe();





