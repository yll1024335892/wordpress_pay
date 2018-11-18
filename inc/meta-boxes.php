<?php
//$GLOBALS['postotherData'] = postother_get_row($_GET[post]);
$GLOBALS['postotherData']="";
// 文章SEO
$seo_post_meta_boxes =
    array(
        "description" => array(
            "name" => "descript",
            "std" => "",
            "title" => "商品的描述(放到meta标签中)",
            "type" => "textarea"),

        "keywords" => array(
            "name" => "keyword",
            "std" => "",
            "title" => "商品关键词(放到meta标签中)",
            "type" => "text"),

    );
// 面板内容
function seo_post_meta_boxes()
{
    global $post, $seo_post_meta_boxes;
    //获取保存
    foreach ($seo_post_meta_boxes as $meta_box) {
        $tempKey = $meta_box['name'];
        $meta_box_value = $GLOBALS['postotherData'][$tempKey];
        if ($meta_box_value != "") {
            //将默认值替换为已保存的值
            $meta_box['std'] = $meta_box_value;
        }
        echo '<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
        //选择类型输出不同的html代码
        switch ($meta_box['type']) {
            case 'title':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                break;
            case 'text':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                echo '<span class="form-field"><input type="text" size="40" name="' . $meta_box['name'] . '" value="' . $meta_box['std'] . '" /></span><br />';
                break;
            case 'textarea':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                echo '<textarea id="seo-excerpt" cols="40" rows="2" name="' . $meta_box['name'] . '">' . $meta_box['std'] . '</textarea><br />';
                break;
            case 'radio':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                $counter = 1;
                foreach ($meta_box['buttons'] as $radiobutton) {
                    $checked = "";
                    if (isset($meta_box['std']) && $meta_box['std'] == $counter) {
                        $checked = 'checked = "checked"';
                    }
                    echo '<input ' . $checked . ' type="radio" class="kcheck" value="' . $counter . '" name="' . $meta_box['name'] . '_value"/>' . $radiobutton;
                    $counter++;
                }
                break;
            case 'checkbox':
                if (isset($meta_box['std']) && $meta_box['std'] == 'true') $checked = 'checked = "checked"';
                else $checked = '';
                echo '<br /><input type="checkbox" name="' . $meta_box['name'] . '" value="true"  ' . $checked . ' />';
                echo '<label>' . $meta_box['title'] . '</label><br />';
                break;
        }

    }
}

// 创建面板
function seo_post_meta_box()
{
    global $theme_name;
    if (function_exists('add_meta_box')) {
        add_meta_box('seo_post_meta_box', '商品的SEO设置', 'seo_post_meta_boxes', 'post', 'normal', 'high');
    }
}

// 保存数据
function save_seo_post_postdata($post_id)
{
    $basename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if(strpos("efhl".$basename, "admin-ajax")){
        return;
    }
    $res = postother_get_row($post_id);
    if ($res == "" || $res == null) {
        //存储
        postother_insert_seo($post_id, $_POST['descript'] . '', $_POST['keyword'] . '');
    } else {
        //更新
        postother_update_seo($post_id, $_POST['descript'] . '', $_POST['keyword'] . '');
    }
}

// 触发
//add_action('admin_menu', 'seo_post_meta_box', 100);
//add_action('save_post', 'save_seo_post_postdata', 10, 1);
// 主图
$mainpictrue_post_meta_boxes =
    array(
        "main_picture1" => array(
            "name" => "main_picture1",
            "std" => "",
            "title" => "主图1",
            "type" => "upload"),
        "main_picture2" => array(
            "name" => "main_picture2",
            "std" => "",
            "title" => "主图2",
            "type" => "upload"),
        "main_picture3" => array(
            "name" => "main_picture3",
            "std" => "",
            "title" => "主图3",
            "type" => "upload"),
    );

// 面板内容
function mainpictrue_post_meta_boxes()
{
    global $post, $mainpictrue_post_meta_boxes;
    //获取保存
    $index = 0;
    $picArr = explode('@', $GLOBALS['postotherData']['picture']);
    foreach ($mainpictrue_post_meta_boxes as $meta_box) {
        $tempKey = $meta_box['name'];
        $meta_box_value = $picArr[$index];
        if ($meta_box_value != "") {
            //将默认值替换为已保存的值
            $meta_box['std'] = $meta_box_value;
        }
        echo '<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
        //选择类型输出不同的html代码
        switch ($meta_box['type']) {
            case  'upload': {
                echo '<div id="section-' . $meta_box['name'] . '" class="section section-upload"><div class="option"><div class="controls">';
                echo Options_Framework_Media_Uploader::optionsframework_uploader($meta_box['name'], $meta_box['std'], null);
                echo '</div></div></div>';
            }
                break;
        }
        $index++;
    }
}

// 创建面板
function mainpictrue_post_meta_box()
{
    global $theme_name;
    if (function_exists('add_meta_box')) {
        add_meta_box('mainpictrue_post_meta_box', '主图设置', 'mainpictrue_post_meta_boxes', 'post', 'normal', 'high');
    }
}

// 保存数据
function save_mainpictrue_post_postdata($post_id)
{
    $basename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if(strpos("efhl".$basename, "admin-ajax")){
        return;
    }
    $tempTempUrl = get_template_directory_uri();
    $start = strpos($tempTempUrl, 'themes');
    $tempfolderName = substr($tempTempUrl, $start + 7);
    $tempfolderName = str_replace("-", "_", $tempfolderName);
    $picArr = $_POST[$tempfolderName];
    if (count($picArr)) {
        $picStr = join('@', array_filter($picArr));
    } else {
        $picStr = "";
    }
    $res = postother_get_row($post_id);
    if ($res == "" || $res == null) {
        postother_insert_pic($post_id, $picStr);
    } else {
        postother_update_pic($post_id, $picStr);
    }
}

// 触发
add_action('admin_menu', 'mainpictrue_post_meta_box', 10);
add_action('save_post', 'save_mainpictrue_post_postdata');
// 商品的价格的处理
$price_post_meta_boxes =
    array(
        "price_actual" => array(
            "name" => "price_actual",
            "std" => "",
            "title" => "销售价格",
            "type" => "text"),

        "price_market" => array(
            "name" => "price_market",
            "std" => "",
            "title" => "市场价格",
            "type" => "text"),
        "resource" => array(
            "name" => "resource",
            "std" => "",
            "title" => "网盘的链接",
            "type" => "textarea")

    );

// 面板内容
function price_post_meta_boxes()
{
    global $post, $price_post_meta_boxes;
    //获取保存
    foreach ($price_post_meta_boxes as $meta_box) {
        $tempKey = $meta_box['name'];
        $meta_box_value = $GLOBALS['postotherData'][$tempKey];
        if ($meta_box_value != "") {
            //将默认值替换为已保存的值
            $meta_box['std'] = $meta_box_value;
        }
        echo '<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
        //选择类型输出不同的html代码
        switch ($meta_box['type']) {
            case 'text':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                echo '<span class="form-field"><input type="text" size="40" name="' . $meta_box['name'] . '" value="' . $meta_box['std'] . '" /></span><br />';
                break;
            case 'textarea':
                echo '<h4>' . $meta_box['title'] . '</h4>';
                echo '<textarea id="seo-excerpt" cols="40" rows="2" name="' . $meta_box['name'] . '">' . $meta_box['std'] . '</textarea><br />';
                break;
        }
    }
}

// 创建面板
function price_post_meta_box()
{
    global $theme_name;
    if (function_exists('add_meta_box')) {
        add_meta_box('price_post_meta_box', '商品的价格设置', 'price_post_meta_boxes', 'post', 'normal', 'high');
    }
}

// 保存数据
function save_price_post_postdata($post_id)
{
    $basename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if(strpos("efhl".$basename, "admin-ajax")){
        return;
    }
    $res = postother_get_row($post_id);
    if ($res == "" || $res == null) {
        postother_insert_price($post_id, $_POST['price_actual'], $_POST['price_market'],$_POST['resource'].'');
    } else {
        postother_update_price($post_id, $_POST['price_actual'], $_POST['price_market'],$_POST['resource'].'');
    }
}

// 触发
add_action('admin_menu', 'price_post_meta_box', 11);
add_action('save_post', 'save_price_post_postdata');

//删除扩展文章的表的其它数据
function postother_delete($post_id)
{
    postother_delete_row($post_id);
}

add_action('delete_post', 'postother_delete');
