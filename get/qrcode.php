<?php
// 获取来自请求的 Base64 编码图片
$base64 = $_REQUEST['image'];
$base64_string = 'data:image/png;base64,' . $base64; 

// 移除头部的 `data:image/` 之类的标识
$img_data = explode(',', $base64_string);
$img_base64 = base64_decode($img_data[1]);

// 将解码后的图片保存到文件
$file_path = 'decoded_image.png';
file_put_contents($file_path, $img_base64);

// 使用 cURL 以表单格式发送文件到 API
$res = get_curl('https://api.lau.plus/qrcode/decode/api.php', $file_path);

// 检查 API 响应并提取文本（假设 API 返回的是 JSON 格式）
$response_data = json_decode($res, true);
//echo json_encode($response_data);
if($response_data['code']==200){
    $url = $response_data['link'];
    $res = array('code'=>200,'url'=>$url);
    echo json_encode($res,448);
}else{
    $res = array('code'=>0,'msag'=>$response_data['msg']);
    echo json_encode($res,448);
}


// 发送文件到 API 的函数
function get_curl($url, $file_path)
{
    $ch = curl_init();

    // 准备文件信息，手动设置 Content-Type 为图像类型
    $file = new CURLFile(realpath($file_path), 'image/png');

    // 准备要发送的数据，'file' 是表单的字段名
    $post_fields = array('file' => $file);

    // 设置 cURL 选项
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); // 文件以 POST 方式上传
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    // 执行 cURL 请求
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch); // 输出错误信息
    }

    curl_close($ch);
    return $response;
}
?>
