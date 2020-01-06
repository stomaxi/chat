<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/17
 * Time: 14:42:02
 */

namespace App\Generator\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
trait UserControllerTrait
{
    public function __construct()
    {

        $this->repositoryClass = UserRepository::class;
    }

    protected  function storeData(Request $request)
    {
        return [
        'name'=>$request->input('name'),
                'moblie'=>$request->input('moblie'),
                'password'=>$request->input('password'),
                'pic'=>$request->input('pic'),
                'identity'=>$request->input('identity'),
                'grade'=>$request->input('grade'),
                'fraction'=>$request->input('fraction'),
                'rememberToken'=>$request->input('rememberToken'),
                ];

     }
    protected  function updateData(Request $request)
    {
        return [
                    'password'=>$request->input('password'),
        ];

     }
}