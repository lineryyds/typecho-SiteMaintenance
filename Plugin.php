<?php
/**
 * 一个简单的自定义站点维护插件
 *
 * @package SiteMaintenance
 * @author 玖琳
 * @version 1.3.4
 * @link https://lin-blog.xyz
 */

class SiteMaintenance_Plugin implements Typecho_Plugin_Interface
{
    //激活插件方法，添加设置项
    public static function activate()
    {
        //注册启用插件的回调方法
        Typecho_Plugin::factory('Widget_Archive')->beforeRender = array('SiteMaintenance_Plugin', 'checkMaintenanceMode');
    }

    //禁用插件方法，删除设置项
    public static function deactivate()
    {
        return "SiteMaintenance 插件禁用成功！";
    }

    //初始化方法，检查是否启用了站点维护模式
    public static function checkMaintenanceMode()
{
    $options = Helper::options();

    if ($options->plugin('SiteMaintenance')->maintenanceMode) {
        $selectedTemplate = $options->plugin('SiteMaintenance')->templateSelector;

        if ($selectedTemplate == 'template') {
            // 显示模板内容
            echo '<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>富贵险中求,也在险中丢.</title>
        <style>
            .container {
                width: 60%;
                margin: 10% auto 0;
                background-color: #f0f0f0;
                padding: 2% 5%;
                border-radius: 10px;
                text-align: center;
                font-size: 18px;
            }
            ul {
                padding-left: 20px;
            }
            ul li {
                list-style-type: none;
                line-height: 2.3
            }
            a {
                color: #20a53a
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>行路难</h1>
            <h4>李白</h4>
            <ul>
                <li>金樽清酒斗十千，玉盘珍羞直万钱。</li>
                <li>停杯投箸不能食，拔剑四顾心茫然。</li>
                <li>欲渡黄河冰塞川，将登太行雪满山。</li>
                <li>闲来垂钓碧溪上，忽复乘舟梦日边。</li>
                <li>行路难，行路难，多歧路，今安在？</li>
            </ul>
            <h3>长风破浪会有时，直挂云帆济沧海。</h3>
        </div>
    </body>
</html>';
        } else {
            // 显示自定义内容
            echo $options->plugin('SiteMaintenance')->content;
        }

        exit;
    }
}


    //插件配置方法
    public static function config(Typecho_Widget_Helper_Form $form)
{
    $maintenanceMode = new Typecho_Widget_Helper_Form_Element_Radio(
        'maintenanceMode',
        array('0' => '关闭', '1' => '开启'),
        '0',
        _t('站点维护模式'),
        _t('是否启用站点维护模式')
    );
    $form->addInput($maintenanceMode);

    $content = new Typecho_Widget_Helper_Form_Element_Textarea(
        'content',
        NULL,
        '站点维护',
        _t('维护页面内容'),
        _t('在维护模式下显示的内容：支持html(可直接内嵌网页)')
    );
    $form->addInput($content);

    // 添加按钮
    $templateSelector = new Typecho_Widget_Helper_Form_Element_Select(
        'templateSelector',
        array(
            'template' => _t('使用模板(行路难)'),
            'custom' => _t('使用自定义内容')
        ),
        'template',
        _t('选择维护页面模板')
    );
    $form->addInput($templateSelector);
}

    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
    }
}