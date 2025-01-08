# ZeMenu
一款Typecho主题菜单自定义插件，支持拖拽，市面上其实已经有同类型产品了，不过代码不够简洁，我玩不转，所以自己花了点时间搞了个简单直接的！

### 使用
启动插件后，在typecho后台的菜单中就会多出来一项【管理菜单】，进入该页面即可自定义主题菜单，可创建菜单，也可以从右侧候选里面向左拖拽菜单。

菜单内部顺序也支持上下拖拽，且支持二级分类

### 主题适配
如下，先判断插件是否激活，激活了就获取菜单数组，然后自行遍历数组适配自己主题即可。
```
<?php
if (array_key_exists('ZeMenu', Typecho_Plugin::export()['activated'])){
$nemuarray=ZeMenu_Plugin::zemenu();
}
 ?>
```
如何判断菜单是否处于`active`状态？通过判断链接即可实现，如下即可获取当前页面网址，然后判断菜单链接和它是否一致然后在为其追加`active`的`class`
```
$thisPageUrl=$this->request->getRequestUrl();
```

### 支持

![要饭](https://91ntr.cn/yaofan.webp)
