<?php

require_once 'vendor/autoload.php';
use \wishlist\utils\ConnectionFactory;
use \wishlist\models\Item;
use \wishlist\models\Liste;
use \wishlist\models\User;

use wishlist\utils\HtmlLayout;

$app = new \Slim\Slim();
$db = ConnectionFactory::makeConnection();

$app->get('/', function(){
    test();
});

function test(){
    HtmlLayout::header('Test');
    echo ('
        <div class="jumbotron">
            <div class="container">
                <h1 class="display-4">Salut le gang !</h1>
                <button type="button" class="btn btn-primary" id="btn">Vas y clique !</button>
            </div>
        </div>
        <script>
            document.getElementById("btn").addEventListener("click", () => alert("Salut"));
        </script>
    ');
    HtmlLayout::footer();
}

$app->run();

?>