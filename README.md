# langzi_auth
浪子授权系统PHP全开源版本
此版本没有任何授权我已经去除授权，随意二开无任何加密。

修复不能下载，修复不能更新，修复不能删除用户，修复不能删除授权，增加代理后台管理，重写授权读取文件，修复已经知道漏洞。

```php
if(!isset($_SESSION['authcode'])){
    $query = curl_get("http://授权站域名/check.php?url=".$_SERVER["HTTP_HOST"]."&authcode=".authcode);
    if ($query = json_decode($query, true)) {
        if ($query["code"] == 1) {
            $_SESSION["authcode"] = authcode;
        }else{
            sysmsg("<h3>".$query["msg"]."</h3>", true);
        }
    }
}
```



验证代码Demo 请将代码植入到项目中
```php
<?php
// curl_get 函数，用于执行 GET 请求
function curl_get($url) {
    $ch = curl_init(); // 初始化CURL会话
    curl_setopt($ch, CURLOPT_URL, $url); // 设置请求的URL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 返回请求结果而非直接输出
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过SSL验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 跳过SSL主机验证
    $output = curl_exec($ch); // 执行请求并获取响应
    curl_close($ch); // 关闭CURL会话
    return $output; // 返回响应结果
}

// sysmsg 函数，用于输出系统消息
function sysmsg($msg, $exit = false) {
    echo $msg; // 输出消息
    if ($exit) {
        exit(); // 如果设置为true，停止执行
    }
}

// 示例授权码
$authcode = "你的授权码"; // 这里需要将'你的授权码'替换为实际的授权码

if(!isset($_SESSION['authcode'])){
    $query = curl_get("https://auth.wicdn.com/check.php?url=".$_SERVER["HTTP_HOST"]."&authcode=".$authcode);
    if ($query = json_decode($query, true)) {
        if ($query["code"] == 1) {
            $_SESSION["authcode"] = $authcode;
            echo 'success';
        } else {
            sysmsg("<h3>".$query["msg"]."</h3>", true);
        }
    }
}


```
