<?php

namespace App\Model;

use Lib\Dao;
use App\Model\Administrator;
use App\Model\Client;
use App\Model\Commerce;
use App\Model\Product;

class Home
{
    public static function getCommerces()
    {
        return (is_array(Commerce::listComercios()) && count(Commerce::listComercios()) > 0) ? count(Commerce::listComercios()) : 0;
    }

    public static function getProducts()
    {
        return (is_array(Product::listProdutos()) && count(Product::listProdutos()) > 0) ? count(Product::listProdutos()) : 0;
    }

    public static function getAdministrators()
    {
        return (is_array(Administrator::listAdministradores()) && count(Administrator::listAdministradores()) > 0) ? count(Administrator::listAdministradores()) : 0;
    }

    public static function getClients()
    {
        return (is_array(Client::listClientes()) && count(Client::listClientes()) > 0) ? count(Client::listClientes()) : 0;
    }

    public static function getCountFilters()
    {
        $dayMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $count = [];

        for ($i = 1; $i <= $dayMonth; $i++) {
            if ($i <= date('d')) {
                $sql = new Dao();
                $list = $sql->allSelect("SELECT COUNT(dtfiltro) AS dtFilter FROM tbfiltrocliente WHERE dtfiltro LIKE '%" . date('Y-m-d', strtotime(date('Y') . "-" . date('n') . "-"  . $i)) . "%'");
                $count[$i] = $list[0];
            }
        }

        return $count;
    }
}