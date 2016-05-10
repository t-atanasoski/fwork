<?php

namespace FwLibraries;

class TwController extends \Fwork\Controller
{

    private $twig;

    public function __construct()
    {
        parent::__construct();
    }


    private function _loadTwig()
    {
        if($this->twig == null){
            $loader = new \Twig_Loader_Filesystem($this->config->get('paths.views'));
            $this->twig = new \Twig_Environment($loader);
        }
    }

    public function _getTwig()
    {
        $this->_loadTwig();
        return $this->twig;
    }

    public function _renderView($view, $vars)
    {
        return $this->_getTwig()->render($view, $vars);
    }

    public function _dumpView($view, $vars)
    {
        echo $this->_getTwig()->render($view, $vars);
    }
} 