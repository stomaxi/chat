<?php
/**
* Created by PhpStorm.
* User: apple GeneratorCommand
* Date: 2020/01/08
* Time: 19:50:46
*/

namespace App\Generator\Repositories;

use App\Storage\Storage;
trait MerchantCashOrderRepositoryTrait
{
    public function __construct(\App\Storage\Database\MerchantCashOrder $persistence)
    {
        parent::__construct($persistence);
    }

    public function store(array $newData)
    {
        //todo  wirete new data login
        $model = $this->storage();
        $model->uid  =  $newData['uid'];
        $model->order  =  $newData['order'];
        $model->type  =  $newData['type'];
        $model->num  =  $newData['num'];
        return $this->save($model);
    }
    public function update(Storage $oldModel, array $updateData)
    {
        //todo  wirete update  data login
        return false;
    }

}