# sql-compare
开发数据库与测试数据做对比

### 开发初衷
发现在开发过程中总会不断的添加修改数据库字段当开发的时候就不知道哪些字段添加哪些表添加了 由于项目的原因没有使用到数据库管理工具 索性就用几个小时做个管理下 方便后面后 

### 使用
由于设计到数据库安全问题 建议不要在正式服务器上操作以免泄漏数据结构
下载下来以后修改
~~~javascript
//index/index/index.php
protected $_db1 = '改成自己的数据库';
protected $_db2 = '改成自己的数据库';
~~~

~~~javascript
//config.php
'login_user'  => 'chenrj',//改成自己的
'login_password'  => '123456',//改成自己的
~~~
### 截图
![Alt text](https://github.com/carter911/sql-compare/blob/master/public/static/images/login.jpg)
![Alt text](https://github.com/carter911/sql-compare/blob/master/public/static/images/home.jpg)
![Alt text](https://github.com/carter911/sql-compare/blob/master/public/static/images/table.jpg)
![Alt text](https://github.com/carter911/sql-compare/blob/master/public/static/images/view_table.jpg)
![Alt text](https://github.com/carter911/sql-compare/blob/master/public/static/images/db1.jpg)
![Alt text](https://github.com/carter911/sql-compare/blob/master/public/static/images/copy.jpg)


