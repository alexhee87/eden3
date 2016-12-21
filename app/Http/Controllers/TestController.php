<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use App\Permission;
use Entrust;
use DB;

Class TestController extends Controller
{
    public function index(){
        echo 'ok';
        die;
    }
}