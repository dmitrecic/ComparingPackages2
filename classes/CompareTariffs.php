<?php

class CompareTariffs implements Tariff
{
    private $consumption = 0;
    private $products = "";
    private $product = "";
    private $meta = "";
    private $results = array();

    public function __construct($consumption)
    {
        $this->consumption = $consumption;
        $this->getMeta();
        $this->getProducts();
        $this->compareTariffs();
        $this->sortResults();
        $this->results = json_encode($this->results);
        return $this;
    }

    public function display()
    {
        $results = json_decode($this->results);

        echo "<ul>";
        foreach ($results as $result) {
            echo "<li>".$result->name . " (".$this->consumption." ".$this->meta->unit.") = " . $result->price . " " . $result->calculation . "</li>";
        }
        echo "</ul>";
    }

    private function sortResults()
    {
        array_multisort($this->results, SORT_ASC);
    }

    private function getProducts()
    {
        $this->products = json_decode(Products::getProducts());
    }

    private function getMeta()
    {
        $this->meta = json_decode(MetaData::getMetaData());
    }


    private function compareTariffs()
    {
        foreach ($this->products as $product) {
            $this->product = $product;
            $this->results[] = (array("price" => $this->makeCompare(), "name" => $this->getName(), "calculation" => $this->getMoney() . "/" . $this->getPeriod()));
        }
    }

    private function getName()
    {
        return $this->product->name;
    }

    private function getMoney()
    {
        return $this->meta->money;
    }

    private function getPeriod()
    {
        return $this->meta->yearly;
    }

    private function makeCompare()
    {
        /*
         * check if key name limit in JSON product exists
         * if not exists or if it is 0 then it is a base tariff
         * otherwise is flat with limit (packaged) tariff
         */

        if (!isset($this->product->limit) || $this->product->limit==0){
            $return = $this->getBasicTariff();
        }
        else
        {
            $return = $this->getPackagedTariff();
        }
        return $return;
    }

    private function setBasePrice()
    {
        $amount = ($this->product->basepriceper=="month" ? $this->product->baseprice*12 : $this->product->baseprice);
        return $amount;
    }

    private function getBasicTariff()
    {
        $baseprice=$this->setBasePrice();
        $kwhprice=$this->product->kwhprice;
        $totalprice=($kwhprice * $this->consumption) + $baseprice;
        return $totalprice;

    }

    private function getPackagedTariff()
    {
        $baseprice=$this->setBasePrice();
        $kwhprice=$this->product->kwhprice;
        $totalprice= $baseprice + ($this->consumption > $this->product->limit ? ($this->consumption - $this->product->limit) * $kwhprice : 0);
        return $totalprice;
    }

}