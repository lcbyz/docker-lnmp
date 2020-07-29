# docker-lnmp
[docker-lnmp](https://github.com/yuxingfei/docker-lnmp) docker web环境，包含 Linux、nginx官方最新版、mysql5.6、php-fpm7.2、php-fpm7.4、redis6.0镜像，其中php-fpm镜像都加载了composer工具、gd、mysql、pdo_mysql、mysqli、redis相关常用扩展。

## docker-compose.yml文件叙述
```
version: '3'
services:
        #mysql5.6数据库镜像
        mysql56:
                image: 474949931/mysql56:v1
                #暴露内部服务访问端口,便于外部链接访问
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
                image: redis:latest
                expose:
                        - "6379"
                ports:
                        - "6379:6379"
                #挂载redis配置文件，和redis持久化数据目录
                volumes:
                        - ./redis/conf/redis.conf:/usr/local/etc/redis/redis.conf
                        - ./redis/data:/data
                command:
                        - /bin/bash
                        - -c
                        - |
                                redis-server /usr/local/etc/redis/redis.conf
        php-fpm72:
                #php-fpm7.2镜像，根据官方镜像加载了composer工具、redis、pdo_mysql、mysql、gd等许多常用php扩展
                image: 474949931/php-fpm72:latest
                expose:
                        - "9000"
                #php-fpm执行用户,镜像中默认为www-data用户,指定为宿主机php-fpm的执行用户,用户id需要根据宿主机的用户id自行填写，列如:id www 可查看www的用户id，填写即可
                user: 1001:1001
                volumes:
                        - ./nginx/www:/var/www/html
                        - ./php72/conf/php.ini:/usr/local/etc/php/php.ini
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
                        - ./php74/conf/php.ini:/usr/local/etc/php/php.ini
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
                        - ./nginx/logs:/var/log/nginx
                links:
                        - php-fpm74
                        - php-fpm72

``` 

## 补充

交流QQ群：[682096728](https://jq.qq.com/?_wv=1027&k=8SMveoJ0)
