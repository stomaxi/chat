<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/25
 * Time: 18:09:29
 */

namespace App\Generator\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
trait TaskControllerTrait
{
    public function __construct()
    {

        $this->repositoryClass = TaskRepository::class;
    }

    protected  function storeData(Request $request)
    {
        return [
        'sendUid'=>$request->input('sendUid'),
                'num'=>$request->input('num'),
                'price'=>$request->input('price'),
                'money'=>$request->input('money'),
                'status'=>$request->input('status'),
                'repeatNum'=>$request->input('repeatNum'),
                'uid'=>$request->input('uid'),
                'pay'=>$request->input('pay'),
                ];

     }
    protected  function updateData(Request $request)
    {
        return [
                    'price'=>$request->input('price'),
                            'money'=>$request->input('money'),
                            'status'=>$request->input('status'),
                            'repeatNum'=>$request->input('repeatNum'),
        ];

     }
}