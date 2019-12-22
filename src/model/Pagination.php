<?php

namespace App\src\model;
use App\src\DAO\DAO;

class Pagination extends DAO
{

    private $_start;
    private $_limit;
    private $_total;
    private $_getPage;

    /**
     * __construct
     *
     * @param  int nb of element per page
     * @param  mixed super variable GET to retrieve the page number
     *
     * @return void
     */
    public function __construct($limit, $getPage)
    {
        $this->_limit = $limit;//limit
        $this->_getPage = $getPage;
    }

    /**
     * return the offset for SQL LIMIT
     *
     * @return void
     */
    public function offset()
    {
        $this->_start = 0;//offset
        $current_page = isset($this->_getPage) ? $this->_getPage : 1;
        if($current_page > 1){
            $this->_start = ($current_page * $this->_limit) - $this->_limit;
        }

        return $this->_start;
    }

    /**
     * return the total Pages
     *
     * @param  object $element = chapters, users, newsletters, etc
     * @param  mixed $table DB table
     *
     * @return void
     */
    public function totalPages($element, $table) {
        $this->_total = count($element);
        $stmt = $this->createQuery("SELECT id FROM $table");
        $this->_total = $stmt->rowCount();

        return $this->_total;
    }

}