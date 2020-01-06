<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/24
 * Time: 10:29:27
 */

namespace App\Generator\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GroupchatRepository;
trait GroupchatControllerTrait
{
    public function __construct()
    {

        $this->repositoryClass = GroupchatRepository::class;
    }

    protected  function storeData(Request $request)
    {
        return [
        'name'=>$request->input('name'),
                'status'=>$request->input('status'),
                ];

     }
    protected  function updateData(Request $request)
    {
        return [
                    'status'=>$request->input('status'),
        ];

     }
}