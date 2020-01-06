<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/25
 * Time: 10:41:45
 */

namespace App\Generator\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TalkRepository;
trait TalkControllerTrait
{
    public function __construct()
    {

        $this->repositoryClass = TalkRepository::class;
    }

    protected  function storeData(Request $request)
    {
        return [
        'uid'=>$request->input('uid'),
                'type'=>$request->input('type'),
                'content'=>$request->input('content'),
                ];

     }
    protected  function updateData(Request $request)
    {
        return [
                    'type'=>$request->input('type'),
        ];

     }
}