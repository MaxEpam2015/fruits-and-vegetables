<?php

namespace App\Interfaces;

use Symfony\Component\HttpFoundation\Request;

interface GroceryCrudInterface
{

    public function add(Request $request);
    public function remove(int $id);
    public function list(Request $request);

}