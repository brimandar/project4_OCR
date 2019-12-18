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
    public function __construct($nbPerPage, $getPage)
    {
        $this->_limit = $nbPerPage;//limit
        $this->_getPage = $getPage;
    }

    /**
     * curren tPage
     *
     * @return void
     */
    protected function currentPage()
    {
        return $current_page = isset($getPage) ? $getPage : 1;
    }

    /**
     * return the offset for SQL LIMIT
     *
     * @return void
     */
    public function offset()
    {
        $start = 0;//offset
        if($this->currentPage() > 1){
            $this->_start = ($this->$current_page * $this->_limit) - $this->_limit;
        }

        return $start;
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