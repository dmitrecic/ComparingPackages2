<?php

class MetaData
{

    public static function getMetaData()
    {
        $meta = array("money"=>"€", "unit"=>"kwh", "month"=>"12", "year"=>"1", "yearly"=>"year");
        return json_encode($meta);
    }

}