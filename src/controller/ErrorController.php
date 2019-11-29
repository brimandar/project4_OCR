<?php

namespace App\src\controller;

class ErrorController extends Controller
{
    public function errorNotFound()
    {
        echo 'Erreur 404. Page introuvable';
    }

    public function errorServer()
    {
        echo 'Erreur 500. Le serveur ne répond pas';
    }
}