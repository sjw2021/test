基本环境:
php版本 7.1.24


[nginx 配置]
server{
        listen 80;
        index index.html index.htm index.php;
        root /data/www/test;
        server_name www.jjwxc.net;

        location ~ [^/]\.php(/|$)
        {
            try_files $uri =404;
            fastcgi_pass  127.0.0.1:9000;
            fastcgi_index index.php;
            include fastcgi.conf;
        }

        location / {
                rewrite ^(.*)$ /index.php?s=/$1 last;
                break;
        }
}
[接口]
获取帖子列表接口: http://www.jjwxc.net/index 请求类型:get 参数:page 页码 ,size 每页显示内容
发帖接口: http://www.jjwxc.net/add 请求类型:post 参数:subject 标题, Author 作者, Body 内容


[接口返回参数]
失败接口
{"err_code":1,"msg":"数据库连接失败,"data":[]}
成功接口
{"err_code":0,"msg":"请求成功,"data":[]}