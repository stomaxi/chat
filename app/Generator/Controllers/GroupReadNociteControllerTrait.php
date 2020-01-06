<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/24
 * Time: 17:02:36
 */

namespace App\Generator\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GroupReadNociteRepository;
trait GroupReadNociteControllerTrait
{
    public function __construct()
    {

        $this->repositoryClass = GroupReadNociteRepository::class;
    }

    protected  function storeData(Request $request)
    {
        return [
        'uid'=>$request->input('uid'),
                'nociteId'=>$request->input('nociteId'),
                ];

     }
    protected  function updateData(Request $request)
    {
        return [
];

     }
}