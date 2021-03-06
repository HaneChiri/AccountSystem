# AccountSystem
一个账户系统。主要使用php，从零开始学习，边学习边更新。由于使用英文注释影响我的积极性以及影响阅读量，我就都使用中文算了。


## 开发环境

easyPHP 12.1（Apache 2.4.2，MySQL 5.5.27，PHP 5.4.6）

## 当前版本:v1.0.0

上一个版本：v0.1.0

版本号规则：vA.B.C(A：不可向下兼容的大修改；B：向下兼容的功能更新；C:向下兼容的bug修改)

最后修改日期：2018-9-8

## 本次功能更新：

1. 增加了几个数据库字段（不向下兼容的主要原因）；
2. 增加了密码保护问题，用于忘记密码时修改密码；
3. 增加了确认密码表单项；
4. 优化了登陆后跳转方式，由“回到主页”转成“回到上一页或者主页”；
5. 增加了查看用户在线状态的字段；
6. 增加了用户权限的区别；
7. 增加了注册日期的字段；
8. 优化了代码结构，将一些代码封装为函数到文件当中；
9. 增加了设置文件，将数据库常量放在设置文件中；

## 本次修复的bug：

1. 修复了中文用户名乱码问题；
2. 修复了中文用户名可重复注册问题；
3. 修复了密码长度可以超过14个字符的问题；

## 数据库设置：

数据库名：users

数据表名：account

字段：

|字段名|类型|默认值|注释|
|-|-|-|-|
|id|INT|自增(A.I.)|用户唯一标识|
|useName|TEXT||用户名|
|password|TEXT||密码|
|email|TEXT||邮箱|
|permission|INT||权限|
|pwdProtectQ|TEXT||密保问题|
|pwdProtectA|TEXT||密保答案|
|isOnline|INT|0|是否在线|
|regDate|DATE||注册日期|
