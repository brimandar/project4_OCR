<?php
namespace App\config;

class Router {

    /**
     * @var string
     */
    private $_viewPath;

    /**
     * @var AltoRouter
     * package installed with composer
     */
    private $_router;

    public function __construct(string $viewPath) 
    {
        $this->_viewPath = $viewPath;
        $this->_router = new \AltoRouter();
    }

    /**
     * get
     * Renvoie l'objet routeur 
     * @param  mixed $url
     * @param  mixed $view
     * @param  mixed $name
     *
     * @return self
     */
    public function get(string $url, string $view, ?string $name = null):self
    {
        $this->_router->map('GET', $url, $view, $name);

        return $this;
    }

    public function run() : self
    {
        $match = $this->_router->match();//Renvoie un tbl avec 3 clés dont target, la cible de la route
        $view = $match['target'];//Récupération du nom de la page php
        // ob_start();
        require $this->_viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        // $content = ob_get_clean();
        // require $this->_viewPath . DIRECTORY_SEPARATOR . '.layouts/default.php';
        
        // return $this;
    }

}