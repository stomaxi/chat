<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/18
 * Time: 17:23:08
 */

namespace App\Generator\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserInfoRepository;
trait UserInfoControllerTrait
{
    public function __construct()
    {

        $this->repositoryClass = UserInfoRepository::class;
    }

    protected  function storeData(Request $request)
    {
        return [
        'uid'=>$request->input('uid'),
                'type'=>$request->input('type'),
                'name'=>$request->input('name'),
                'card'=>$request->input('card'),
                'mobile'=>$request->input('mobile'),
                'jyPassword'=>$request->input('jyPassword'),
                ];

     }
    protected  function updateData(Request $request)
    {
        return [
];

     }
}