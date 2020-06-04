# docker_lnmp
[docker_lnmp](https://github.com/yuxingfei/docker_lnmp) docker web环境，包含 Linux、nginx官方最新版、mysql5.6、php-fpm7.2、php-fpm7.4、redis6.0镜像，其中php-fpm镜像都加载了gd、mysql、pdo_mysql、mysqli、redis相关常用扩展。

## docker-compose.yml文件叙述
```
mysql56:
        #mysql5.6数据库镜像
        image: 474949931/mysql56:v1
        #暴露内部服务访问端口
        expose:
                - "3306"
        #宿主机端口与容器端口映射
        ports:
                - "3306:3306"
        #挂载mysql data存储目录
        volumes:
                - ./mysql/data:/var/lib/mysql
        #设置mysql初始化root密码，自行更改
        environment:
                - MYSQL_ROOT_PASSWORD=root
redis6:
        #根据redis文件夹中Dockerfile文件进行镜像构建，生成redis6.0版本容器
        build: ./redis
        #暴露内部服务访问端口
        expose:
                - "6379"
        #宿主机端口与容器端口映射
        ports:
                - "6379:6379"
        #挂载redis配置文件，和redis持久化数据目录
        volumes:
                - ./redis/conf/redis.conf:/usr/local/etc/redis/redis.conf
                - ./redis/data:/data
php-fpm72:
        #php-fpm7.2镜像，根据官方镜像加载了redis、pdo_mysql、mysql、gd等常用php扩展
        image: 474949931/php-fpm72:v2
        expose:
                - "9000"
        #php-fpm执行用户,镜像中默认为www-data用户,指定为宿主机php-fpm的执行用户,用户id需要根据宿主机的用户id自行填写，列如:id www 可查看www的用户id，填写即可
        user: 1001:1001
        #挂载数据卷到php-fpm中
        volumes:
                - ./nginx/www:/var/www/html
        #连接mysql和redis服务，供内部访问使用
        links:
                - mysql56
                - redis6
php-fpm74:
        image: 474949931/php-fpm74:latest
        expose:
                - "9000"
        #执行用户
        user: 1001:1001
        volumes:
                - ./nginx/www:/var/www/html
        links:
                - mysql56
                - redis6
nginx:
        image: nginx:latest
        expose:
                - "80"
        ports:
                - "80:80"
        volumes:
                - ./nginx/www:/usr/share/nginx/html
                - ./nginx/conf:/etc/nginx/conf.d
        links:
                - php-fpm74
                - php-fpm72


``` 

## 补充

交流QQ群：[682096728](https://jq.qq.com/?_wv=1027&k=8SMveoJ0)
