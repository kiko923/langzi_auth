<?php
// require_once 'curl.php'; // 引入 Curl_Api 文件
class QQ extends Curl_Api
{
    // 获取登录二维码
    public function QRcode()
    {
        // 拼接URL，确保 `time()` 使用正确
        $url = 'https://ssl.ptlogin2.qq.com/ptqrshow?appid=549000912&e=2&l=M&s=4&d=72&v=4&t=0.5409099' . time() . '&daid=5';
        // 发送请求
        $arr = $this->get_curl_split($url);
        // 匹配 qrsig
        preg_match('/qrsig=(.*?);/', $arr['header'], $match);
        
        // 如果匹配到 qrsig
        if (isset($match[1])) {
            return array(
                'code' => 200,
                'qrsig' => $match[1],
                'data' => base64_encode($arr['body']) // 将二维码图像进行 base64 编码
            );
        } else {
            return array('code' => 400, 'msg' => '二维码获取失败');
        }
    }

    // 监听二维码状态
    public function ListenQR($qrsig)
    {
        // 判断 qrsig 是否为数组，并提取第一个元素
        $qrsig = is_array($qrsig) ? $qrsig[0] : $qrsig;

        if (empty($qrsig)) {
            return array('code' => -1, 'msg' => 'qrsig不能为空');
        }

        // 拼接 URL，并调用获取 QRToken 方法
        $url = 'https://ssl.ptlogin2.qq.com/ptqrlogin?u1=https%3A%2F%2Fqzs.qq.com%2Fqzone%2Fv5%2Floginsucc.html%3Fpara%3Dizone&ptqrtoken=' 
            . $this->getqrtoken($qrsig) 
            . '&login_sig=&ptredirect=0&h=1&t=1&g=1&from_ui=1&ptlang=2052&action=0-0-' 
            . time() . '0000&js_ver=10194&js_type=1&pt_uistyle=40&aid=549000912&daid=5&';

        // 发起请求
        $ret = $this->get_curl($url, 0, $url, 'qrsig=' . $qrsig . '; ', 1);

        // 解析响应数据
        if (preg_match("/ptuiCB\('(.*?)'\)/", $ret, $arr)) {
            $r = explode("','", str_replace("', '", "','", $arr[1]));

            // 登录成功
            if ($r[0] == 0) {
                preg_match('/uin=(\d+)&/', $ret, $uin);
                $uin = $uin[1];
                preg_match('/skey=@(.{9});/', $ret, $skey);
                preg_match('/superkey=(.*?);/', $ret, $superkey);

                // 获取进一步的数据
                $data = $this->get_curl($r[2], 0, 0, 0, 1);

                if ($data) {
                    preg_match("/p_skey=(.*?);/", $data, $matchs);
                    $pskey = $matchs[1];
                }

                // 如果获取到了 pskey
                if (isset($pskey)) {
                    if (isset($_GET['findpwd'])) {
                        $_SESSION['findpwd_qq'] = $uin;
                    }
                    return array(
                        'code' => 200,
                        'uin' => $uin,
                        'skey' => '@' . $skey[1],
                        'pskey' => $pskey,
                        'superkey' => $superkey[1],
                        'nick' => $r[5]
                    );
                } else {
                    return array('code' => 201, 'msg' => '登录成功，获取相关信息失败！' . $r[2]);
                }
            }
            // 二维码已失效
            elseif ($r[0] == 65) {
                return array('code' => 400, 'msg' => '二维码已失效。');
            }
            // 二维码未失效
            elseif ($r[0] == 66) {
                return array('code' => 202, 'msg' => '二维码未失效。');
            }
            // 正在验证二维码
            elseif ($r[0] == 67) {
                return array('code' => 302, 'msg' => '正在验证二维码。');
            }
            // 其他错误
            else {
                return array('code' => 401, 'msg' => $r[4]);
            }
        } else {
            return array('code' => 403, 'msg' => $ret);
        }
    }

    // 生成 qr token 的方法
    private function getqrtoken($qrsig)
    {
        $len = strlen($qrsig);
        $hash = 0;
        for ($i = 0; $i < $len; $i++) {
            $hash += (($hash << 5) & 2147483647) + ord($qrsig[$i]) & 2147483647;
            $hash &= 2147483647;
        }
        return $hash & 2147483647;
    }
}

// // 实例化类并调用方法
// $wx = new QQ();
// $ret = $wx->QRcode();
// //echo json_encode($ret);


// echo '<img src="data:image/png;base64,' . $ret['data'] . '" alt="QR Code">';
