<?php

function loadClasses()
{
    require_once("../classes/Tariff.php");
    require_once("../classes/Products.php");
    require_once("../classes/MetaData.php");
    require_once("../classes/CompareTariffs.php");
}

try{
    spl_autoload_register("loadClasses");
} catch (Exception $e) {
    echo "Error loading classes!<br>".$e;
}
/*
 * test!
 */