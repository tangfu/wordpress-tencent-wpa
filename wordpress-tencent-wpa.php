<?php
/*
Plugin Name: Wordpress Tencent WPA
Plugin URI: http://www.rainhome.org/?p=468
Description: 显示临时会话按钮。
Version: 1.0.2
Author: tangfu
Author URI: http://www.rainhome.org

 */
//如果有遇到问题，请到http://www.rainhome.org 得到服务支持！
if ( ! defined( 'WP_PLUGIN_URL' ) )
    define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );//获得plugins网页路径
if ( ! defined( 'WP_PLUGIN_DIR' ) )
    define( 'WP_PLUGIN_DIR', WP_CONTENT_URL. '/plugins' );//获得plugins直接路径

//展示函数
function display_tencent_wpa($args = ''){
    $default = array(
	'username'=>'tangfu',
	'hit'=>'sendmsg to me',
	'idkey'=>'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
    $r = wp_parse_args($args,$default);
    extract($r);

    echo '<a target="_blank" href="http://sighttp.qq.com/authd?IDKEY=' . $idkey . '"><img border="0"  src="http://wpa.qq.com/imgd?IDKEY=' . $idkey . '&pic=41" alt="点击这里给我发消息" title="' . $hit . '"></a>';
}

//扩展类 WP_Widget
class TencentWPA extends WP_Widget
{
    //定义后台面板展示文字
    function TencentWPA(){
	$widget_des = array('classname'=>'wordpress-tencent-wpa','description'=>'在博客显示临时会话按钮');
	$this->WP_Widget(false,'腾讯WPA',$widget_des);
    }

    //定义widget后台选项
    function form($instance){
	$instance = wp_parse_args((array)$instance,array(
	    'title'=>'腾讯WPA',
	    'username'=>'WPA_ID',
		'hit'=>'点击这里给我发消息',
	    'idkey'=>'4735433f9fbf9bb2983d9095595f5c5c36abdd0b'));
	$title = htmlspecialchars($instance['title']);
	$username = htmlspecialchars($instance['username']);
	$hit = htmlspecialchars($instance['hit']);
	$idkey = htmlspecialchars($instance['idkey']);
	echo '<p><b>首次使用请获取IDKEY--></b><a target="_blank" href="http://wp.qq.com">点此获取</a></p><p style="color:#FF3333;">任何问题请到<a target="_blank" href="http://www.rainhome.org">tangfu\'s blog</a> 反馈</p>
	    <p>注意：目前wpa只能用于已经安装了QQ客户端的windows系统</p>
	    <p><label for="'.$this->get_field_name('title').'">侧边栏标题:<input style="width:200px;" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" /></label></p>
	    <p><label for="'.$this->get_field_name('username').'">用户名:<input style="width:200px;" id="'.$this->get_field_id('username').'" name="'.$this->get_field_name('username').'" type="text" value="'.$username.'" /></label></p>
		<p><label for="'.$this->get_field_name('hit').'">提示:<input style="width:200px;" id="'.$this->get_field_id('hit').'" name="'.$this->get_field_name('hit').'" type="text" value="'.$hit.'" /></label></p>
	    <p><label for="'.$this->get_field_name('idkey').'">IDKEY的值: <a target="_blank" href="http://wp.qq.com">[?]</a><input style="width:200px;" id="'.$this->get_field_id('idkey').'" name="'.$this->get_field_name('idkey').'" type="text" value="'.$idkey.'" /></label></p>';
    }

    //更新函数
    function update($new_instance,$old_instance){
	$instance = $old_instance;
	$instance['title'] = strip_tags(stripslashes($new_instance['title']));
	$instance['username'] = strip_tags(stripslashes($new_instance['username']));
	$instance['hit'] = strip_tags(stripslashes($new_instance['hit']));
	$instance['idkey'] = strip_tags(stripslashes($new_instance['idkey']));
	return $instance;
    }

    //显示函数
    function widget($args,$instance){
	extract($args);
	$title = apply_filters('widget_title',empty($instance['title']) ? '&nbsp;' : $instance['title']);
	$username = empty($instance['username']) ? 'WPA_ID' : $instance['username'];
	$hit = empty($instance['hit']) ? '向我发送消息' : $instance['hit'];
	$idkey = empty($instance['idkey']) ? '4735433f9fbf9bb2983d9095595f5c5c36abdd0b' : $instance['idkey'];

	echo $before_widget;
	//echo $before_title . $title . $after_title;
	display_tencent_wpa("username=$username&hit=$hit&idkey=$idkey");
	echo $after_widget;
    }
}

//注册widget
function TencentWpaInit(){
    register_widget('TencentWPA');
}

add_action('widgets_init','TencentWpaInit');
?>
