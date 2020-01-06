<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/21
 * Time: 16:26:19
 */

namespace App\Generator\Controllers;

use Illuminate\Http\Request;
use App\Repositories\FlowRepository;
trait FlowControllerTrait
{
    public function __construct()
    {

        $this->repositoryClass = FlowRepository::class;
    }

    protected  function storeData(Request $request)
    {
        return [
        'uid'=>$request->input('uid'),
                'flowType'=>$request->input('flowType'),
                'source'=>$request->input('source'),
                'num'=>$request->input('num'),
                'beforeNum'=>$request->input('beforeNum'),
                'afterNum'=>$request->input('afterNum'),
                'symbol'=>$request->input('symbol'),
                ];

     }
    protected  function updateData(Request $request)
    {
        return [
                    'flowType'=>$request->input('flowType'),
        ];

     }
}