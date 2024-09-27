<?php
session_start();
require_once 'curl.php'; // 引入 Curl_Api 类
require_once 'qq.php';       // 引入 QQ 类

$wx = new QQ();

// 生成二维码
if ($_GET['action'] == 'getQR') {
    $ret = $wx->QRcode();
    if ($ret['code'] == 200) {
        $_SESSION['qrsig'] = $ret['qrsig'];  // 保存 qrsig
        echo json_encode([
            'code' => 200,
            'qrsig'=>$ret['qrsig'],
            'data' => $ret['data'], // 返回 Base64 二维码图像
        ]);
    } else {
        echo json_encode(['code' => 400, 'msg' => '二维码获取失败']);
    }
}

// 检查二维码扫描状态
if ($_GET['action'] == 'checkQR') {
    if (!isset($_SESSION['qrsig'])) {
        echo json_encode(['code' => 400, 'msg' => 'qrsig 未找到']);
        exit;
    }
    
    $qrsig = $_SESSION['qrsig'];
    $result = $wx->ListenQR($qrsig);
    
    if(isset($result['uin'])){
        echo json_encode(array('code'=>$result['code'],'nick'=>$result['nick'],'uin'=>$result['uin']));  // 返回 ListenQR 的结果
    }else{
        echo json_encode($result);  // 返回 ListenQR 的结果
    }
    
}
