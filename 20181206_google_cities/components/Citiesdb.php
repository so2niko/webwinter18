<?php
/**
 * Created by PhpStorm.
 * User: sotula
 * Date: 06.12.2018
 * Time: 18:54
 */

class Citiesdb
{
    private $connect;
    private $servername;
    private $username;
    private $password;
    private $dbname;

    public function __construct()
    {
        $this->servername = "localhost";
        $this->username = "web2016";
        $this->password = "Password123456";
        $this->dbname = "web2016web2016";

        $this->connect = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
        $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    /*Добавить город
     *  Return:
         * true - город добавлен
         * false - город не добавлен
     * */
    public function insertCity($city)
    {

        if($this->checkCity($city)){
            $squery = "INSERT INTO cities (city) VALUES ('$city')";

            $this->connect->exec($squery);

            echo "['$city добавлен']";
            return true;
        }

        echo "['$city не добавлен']";

        return false;
    }



    public function getCities($cityName)
    {
        $queryLike = "SELECT city FROM cities WHERE city LIKE '$cityName%' ORDER BY city";
        $pre = $this->connect->prepare($queryLike);
        
        $pre->execute();

        $pre->setFetchMode(PDO::FETCH_NUM);

        $arr = $pre->fetchAll();

        $arrAnsw = [];
        foreach($arr as $name)
        {
            array_push($arrAnsw, $name[0]);
        }
        return $arrAnsw;
    }

    private function checkCity($city)
    {
        $sq = "SELECT city FROM cities WHERE city='$city'";

        //Подготовленный запрос. Объект, отвечающий за подготовленный запрос
        $preQu = $this->connect->prepare($sq);

        $preQu->execute();

        $preQu->setFetchMode(PDO::FETCH_ASSOC);

        $cArr = $preQu->fetchAll();

        if(count($cArr) > 0){
            return false;
        }

        return true;
    }


}