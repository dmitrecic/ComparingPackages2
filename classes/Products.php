<?php

class Products
{

    public static function getProducts()
    {
        $product[] = array("name" => "Basic tarrif", "baseprice" => "5", "basepriceper" => "month", "kwhprice" => "0.22");
        $product[] = array("name" => "Packaged tarrif", "baseprice" => "800", "basepriceper" => "year", "limit" => "4000", "kwhprice" => "0.30");
        return json_encode($product);
    }

}