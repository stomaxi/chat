<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/26
 * Time: 11:15:07
 */

namespace App\Generator\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RedPacketRepository;
trait RedPacketControllerTrait
{
    public function __construct()
    {

        $this->repositoryClass = RedPacketRepository::class;
    }

    protected  function storeData(Request $request)
    {
        return [
        'appID'=>$request->input('appID'),
                'service'=>$request->input('service'),
                'url'=>$request->input('url'),
                ];

     }
    protected  function updateData(Request $request)
    {
        return [
];

     }
}