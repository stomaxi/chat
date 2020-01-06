<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2019/09/18
 * Time: 14:45:12
 */

namespace App\Generator\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PayRepository;
trait PayControllerTrait
{
    public function __construct()
    {

        $this->repositoryClass = PayRepository::class;
    }

    protected  function storeData(Request $request)
    {
        return [
        'uid'=>$request->input('uid'),
                'payId'=>$request->input('payId'),
                'name'=>$request->input('name'),
                'account'=>$request->input('account'),
                'payPic'=>$request->input('payPic'),
                'other'=>$request->input('other'),
                ];

     }
    protected  function updateData(Request $request)
    {
        return [
                    'other'=>$request->input('other'),
        ];

     }
}