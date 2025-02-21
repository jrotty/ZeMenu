<?php
$db= Typecho_Db::get();


if(isset($_REQUEST['add'])&&$_REQUEST['add']=='menu'){
    $json = file_get_contents('php://input');
    $insert = $db->update('table.options')->where('name = ?','zemenu')
    ->rows(array('value' => $json));
    $db->query($insert);
    throwJson(array('status' => '1', 'info' => '已保存！'));
}

$result = [];
$query= $db->fetchRow($db->select('value')->from('table.options')->where('name = ?','zemenu'));
if(!empty($query)&&!empty($query['value'])){

    $result = json_decode($query['value'], true);
}else{
$insert = $db->insert('table.options')
    ->rows(array('name' => 'zemenu', 'user' => 0, 'value' => ''));
    $db->query($insert);
}


include 'header.php';
include 'menu.php';
$url=Helper::options()->pluginUrl.'/ZeMenu/';
$button='<div><button onclick="menu.dialog(this)">编辑</button><button onclick="menu.delect(this)">删除</button></div>';
$son='<div x-sort="menu.sort" class="son" x-sort x-sort:group="zemenu"></div>';
?>

<link href="<?php echo $url; ?>style.css?2025" rel="stylesheet">
<div class="main zemenu" x-data>
<div class="container">
<div class="zemenugrid">
    
    
   
<div>
<div class="flex-between">
<h2>菜单</h2><button @click="menu.dialog()">添加</button></div>
<div id="zemenu" class="typecho-page-main okmenu" x-sort="menu.sort" x-sort:group="zemenu">
    
    
<?php 
foreach ($result as $val){
    $sonmenu='';
    if(!empty($val['son'])){
        foreach ($val['son'] as $xval){
            $sonmenu=$sonmenu.'<div class="zemenu-item" :id="$id(\'text-input\')" x-sort:item><div class="flex-between"><a data-name="'.$xval['name'].'" data-a="'.$xval['a'].'" data-icon="'.$xval['icon'].'" data-blank="'.$xval['blank'].'" href="'.$xval['a'].'" target="_blank" title="'.$xval['name'].'">'.$xval['name'].'</a>'.$button.'</div>'.$son.'</div>';
        }
    }
?>
    <div class="zemenu-item" :id="$id('text-input')" x-sort:item><div class="flex-between"><a data-name="<?php echo $val['name'];?>" data-a="<?php echo $val['a'];?>" data-icon="<?php echo $val['icon'];?>" data-blank="<?php echo $val['blank'];?>" href="<?php echo $val['a'];?>" target="_blank" title="<?php echo $val['name'];?>"><?php echo $val['name'];?></a><?php echo $button;?></div><div x-sort="menu.sort" class="son" x-sort x-sort:group="zemenu"><?php echo $sonmenu;?></div></div>
    
    
<?php } ?>
    
</div></div>
 
 
 
 
<div>
<h2>独立页面</h2>
<div class="typecho-page-main" x-sort x-sort:config="{group:{name: 'zemenu',pull: 'clone', put: false}}">
    <div class="zemenu-item" :id="$id('text-input')" x-sort:item><div class="flex-between"><a data-name="网站首页" data-a="<?php Helper::options()->siteUrl() ?>" data-icon="" data-blank="0" href="<?php Helper::options()->siteUrl() ?>" target="_blank" title="首页">网站首页</a><?php echo $button;?></div><?php echo $son;?></div>
<?php \Widget\Contents\Page\Rows::alloc()->to($pages); ?>
  <?php while ($pages->next()): ?>
        <div class="zemenu-item" :id="$id('text-input')" x-sort:item><div class="flex-between"><a data-name="<?php $pages->title(); ?>" data-a="<?php $pages->permalink(); ?>" data-icon="" data-blank="0" href="<?php $pages->permalink(); ?>" target="_blank" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a><?php echo $button;?></div><?php echo $son;?></div>
<?php endwhile; ?>
</div>


<h2>分类</h2>
<div class="typecho-page-main" x-sort x-sort:config="{group:{name: 'zemenu',pull: 'clone', put: false}}">
<?php \Widget\Metas\Category\Rows::alloc()->to($cates); ?>
<?php while ($cates->next()): ?>
   <div class="zemenu-item" :id="$id('text-input')" x-sort:item><div class="flex-between"><a data-name="<?php $cates->name(); ?>" data-a="<?php $cates->permalink(); ?>" data-icon="" data-blank="0" href="<?php $cates->permalink(); ?>" target="_blank"><?php $cates->name(); ?></a><?php echo $button;?></div><?php echo $son;?></div>
<?php endwhile; ?>


</div>
</div>
   
   
   
    
</div>
</div>
</div>





<script defer src="<?php echo $url; ?>sort.min.js"></script>

<script defer src="<?php echo $url; ?>zemenu.js?2025"></script>
<?php

include 'copyright.php';
include 'common-js.php';
if(!array_key_exists('NewAdmin', Typecho_Plugin::export()['activated'])){
?>
<script src="<?php echo $url; ?>alpinejs3.14.8.min.js" defer></script>
<?php } ?>


<?php
function throwJson($message)
{
header('Content-Type: application/json');
echo json_encode($message);
exit;
}
include 'footer.php';
?>