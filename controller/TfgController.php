<?php
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

class TfgController extends BaseController
{
    private $pinchoMapper;
    private $concursoMapper;
    private $establecimientoMapper;
    private $juradoPopularMapper;

    /**
     * PinchoController constructor.
     */
    public function __construct() { 
    parent::__construct();
    
            
   }

    public function index()
    {
        //Creamos la vista
        $this->view->render("tfg", "index");
    }

    
}