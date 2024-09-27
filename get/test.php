<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QQ 登录</title>
</head>
<body>
    <h2>扫描二维码登录</h2>
    <div id="qrCodeContainer">
        <p>正在加载二维码...</p>
    </div>
    <div id="status"></div>

    <script>
        let intervalId;  // 保存定时器ID

        // 获取二维码并显示
        function getQRCode() {
            fetch('ajax.php?action=getQR')
                .then(response => response.json())
                .then(data => {
                    if (data.code === 200) {
                        document.getElementById('qrCodeContainer').innerHTML = '<img src="' + data.data + '" alt="QR Code">';
                        checkQRStatus();  // 开始监听二维码状态
                    } else {
                        document.getElementById('qrCodeContainer').innerHTML = '二维码获取失败';
                    }
                });
        }

        // 定时轮询二维码状态
        function checkQRStatus() {
            intervalId = setInterval(() => {
                fetch('ajax.php?action=checkQR')
                    .then(response => response.json())
                    .then(data => {
                        if (data.code === 200) {
                            document.getElementById('status').innerHTML = '登录成功，欢迎 ' + data.uin;
                            clearInterval(intervalId);  // 登录成功，停止轮询
                        } else if (data.code === 400) {
                            document.getElementById('status').innerHTML = '二维码已失效，请刷新重试。';
                            clearInterval(intervalId);  // 二维码失效，停止轮询
                        } else if (data.code === 302) {
                            document.getElementById('status').innerHTML = '正在验证二维码，请稍后...';
                        } else if (data.code === 202) {
                            document.getElementById('status').innerHTML = '二维码未失效，请继续扫码。';
                        } else {
                            document.getElementById('status').innerHTML = data.msg;
                        }
                    });
            }, 3000);  // 每隔3秒请求一次状态
        }

        // 页面加载时获取二维码
        window.onload = function() {
            getQRCode();
        };
    </script>
</body>
</html>
