<?php
namespace Home\Controller;
use Think\Controller;
class PayController extends Controller {

    public function order_pay(){
        $this->display("pay");
    }

    public function pay(){
        vendor("Pay.TeegonService");
        if(I('post.id') == 1){
            $amount = 0.01;
        }else{
            exit("金额错误");
        }
        $payType = "alipay";
        if(isMobile()){
            $payType = 'alipay_wap';
        }
        $url = "http://".$_SERVER['SERVER_NAME'];
        $param['notify_url'] = $url.U('pay/notify_url');//支付成功后天工支付网关通知
        $param['order_no'] = substr(md5(time().print_r($_SERVER,1)), 0, 24); //订单号
        $param['channel'] = $payType;
        $param['return_url'] = $url.U("pay/return_url");
        $param['amount'] = $amount;
        $param['subject'] = "测试";
        $param['metadata'] = "";
        $param['client_ip'] = get_client_ip();
        $param['client_id'] = C('TEE_PAY.TEE_CLIENT_ID');

        $api_url = C('TEE_PAY.TEE_API_URL');
        $srv = new \TeegonService($api_url);
        if(isWeiXin()){
            $param['channel'] = "wxpay_jsapi";
            $result = $srv->pay($param)->result;
            if(isset($result->id)){
                $url = $api_url."/app/checkout/wx?id=".$result->id ."&channel=wxpaymp_pinganpay&t=".time();
                echo "<script>window.location.href='{$url}'</script>";exit;
            }else{
                exit("支付错误");
            }
        }
        $sign = $srv->sign($param);
        $param['sign'] = $sign;

        $params = "";
        foreach($param as $k=>$v){
            $params .= "$k=$v&";
        }
        $params = substr($params, 0, -1);

        $url = $api_url."charge/pay?".$params;
        header("Location:$url");
    }



    public function return_url(){
        echo "下单成功";
    }

    public function notify_url(){
        \Think\Log::record('测试日志信息');
    }

}