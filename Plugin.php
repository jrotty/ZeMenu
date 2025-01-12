<?php

namespace TypechoPlugin\ZeMenu;

use Typecho\Plugin\PluginInterface;
use Utils\Helper;
use Typecho\Widget\Helper\Form;
use Typecho\Widget\Helper\Form\Element\Text;
use Typecho\Db;
use Widget\Options;


if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 简单的主题菜单自定义插件，需要主题自行适配
 *
 * @package ZeMenu
 * @author 泽泽社长
 * @version 0.8.2
 * @link https://store.typecho.work/
 */
class Plugin implements PluginInterface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     */
    public static $panel  = 'ZeMenu/panel.php';
    
    public static function activate()
    {
        
        \Typecho\Plugin::factory('Widget_Archive')->callZemenu = __CLASS__ . '::zemenu';
        Helper::addPanel(1, self::$panel, '管理菜单', '管理菜单', 'administrator');
    }
    public static function zemenu() {
        $db= Db::get();
        $query= $db->fetchRow($db->select('value')->from('table.options')->where('name = ?','zemenu'));
        $result = json_decode($query['value'], true);
        return $result;
        
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     */
    public static function deactivate()
    {
        Helper::removePanel(1, self::$panel); 
    }

    /**
     * 获取插件配置面板
     *
     * @param Form $form 配置面板
     */
    public static function config(Form $form)
    {
    }

    /**
     * 个人用户的配置面板
     *
     * @param Form $form
     */
    public static function personalConfig(Form $form)
    {
    }

}
