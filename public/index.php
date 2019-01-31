<?php

require("../core/autoload.php");

// input data

$list=new CompareTariffs(6000);
$results = $list->getResults();
$result=json_decode($results);

foreach ($result as $product)
{
    echo $product->name." ";
    echo $product->price. $product->calculation."<br>";
}

?>