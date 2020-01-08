<?php
/**
 * Created by PhpStorm.
 * User: apple GeneratorCommand
 * Date: 2020/01/08
 * Time: 19:50:45
 */
namespace App\Http\Controllers;

use App\Generator\Controllers\MerchantCashOrderControllerTrait;
use App\Repositories\MerchantCashOrderRepository;
use App\Repositories\RedPacketRepository;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MerchantCashOrderController extends Controller
{
    use RESTful,MerchantCashOrderControllerTrait;

    //提现申请
    public function applyForCash(Request $request, TaskRepository $taskRepository, RedPacketRepository $redPacketRepository, MerchantCashOrderRepository $merchantCashOrderRepository)
    {
        $validator = Validator::make($request->all(),[
            'app_id' => 'required|integer',//商户id
            'num' => 'required|integer|between:1,10000',//金额
            'time' => 'required|integer',//发送时间
            'sign' => 'required|string',//签名
        ],[
            'app_id.required' => '请填写商户ID',
            'app_id.integer' => 'ID类型错误',
            'num.required' => '请填写提现数量',
            'num.integer' => '数量必须为整形',
            'num.between' => '提现金额范围为 :min - :max',
            'time.required' => '请填写申请时间',
            'time.integer' => '时间类型错误',
            'sign.required' => '请填写签名',
            'sign.string' => '签名类型错误',
        ]);
        $request_id = $request->app_id;
        $request_num = $request->num;
        $request_time = $request->time;
        $request_sign = $request->sign;
        $valid_time = 600;//请求有效期 10分钟
        $error = $validator->errors()->first();
        if ($error){
            return response()->apiReturn([], 400, $error);
        }
        $time = time();
        if ($time - $valid_time > $request_time){
            return response()->apiReturn([], 400, '请求超时');
        }
        $merchant_mode = $redPacketRepository->getMode($request_id);
        if (!$merchant_mode){
            return response()->apiReturn([], 400, '商户错误');
        }
        $data = [
            'app_id' => $request_id,
            'num' => $request_num,
            'time' => $request_time,
            'service' => $merchant_mode->service,
        ];
        $sing_valid = $taskRepository->checkSign($data,$request_sign);
        if ($sing_valid !== true){
            return response()->apiReturn([], 400, '签名错误');
        }
        $is_existence_wait = $merchantCashOrderRepository->getIsExisteWaitOrder($request_id);
        if ($is_existence_wait){
            return response()->apiReturn([], 400, '请等待上次提现处理完成');
        }
        $flow = $merchant_mode->account->flow;
        if (bccomp($flow, $request_num,2) < 0){
            return response()->apiReturn([], 400, '提现金额不足');
        }
        if (!$merchantCashOrderRepository->isCash($request_id)){
            return response()->apiReturn([], 400, '提现已被冻结');
        }
        $result = $merchantCashOrderRepository->setCashOrder($request_id, $request_num);
        if (!$result){
            return response()->apiReturn([], 400, '提现申请失败');
        }
        return response()->apiReturn([
            'order' => $result->order
        ]);
    }


}
