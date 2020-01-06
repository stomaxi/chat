<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/19
 * Time: 15:07:01
 */

namespace App\Generator\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AccountRepository;
trait AccountControllerTrait
{
    public function __construct()
    {

        $this->repositoryClass = AccountRepository::class;
    }

    protected  function storeData(Request $request)
    {
        return [
        'uid'=>$request->input('uid'),
                'flow'=>$request->input('flow'),
                'frozen'=>$request->input('frozen'),
                'reward'=>$request->input('reward'),
                'status'=>$request->input('status'),
                ];

     }
    protected  function updateData(Request $request)
    {
        return [
                    'flow'=>$request->input('flow'),
                            'frozen'=>$request->input('frozen'),
                            'reward'=>$request->input('reward'),
                            'status'=>$request->input('status'),
        ];

     }
}