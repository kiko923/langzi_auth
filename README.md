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
