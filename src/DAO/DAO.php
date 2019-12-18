<?php

namespace App\src\DAO;

use PDO;
use Exception;

abstract class DAO
{
    //Var storing connection PDO
    private $_connection;

    /**
     * check if a connexion exist or not, avoid useless connection calls
     * 
     */
    private function checkConnection()
    {
        if($this->_connection === null) {
            return $this->getConnection();
        }
        return $this->_connection;
    }


    /**
     * method connect database
     *
     */
    protected function getConnection()
    {
        //Attempt to connect to the database
        try{
            $this->_connection = new PDO(DB_HOST, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->_connection;
        }
        //If error
        catch(Exception $e)
        {
            die ('Erreur de connection :'.$e->getMessage());
        }

    }

    /**
     * create a prepare request or a simple request according to the value of the second parameter
     *
     * @param  mixed $sql
     * @param  mixed $parameters
     *
     */
    protected function createQuery($sql, $parameters = null)
    {
        if($parameters)
        {
            $result = $this->checkConnection()->prepare($sql);
            $result->execute($parameters);
            return $result;
        }
        $result = $this->checkConnection()->query($sql);
        return $result;
    }
}