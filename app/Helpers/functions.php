<?php
/**
 * 传递数据以易于阅读的样式格式化后输出，加入了内存判断机制，提供更好的优化建议 by femri
 * @param data 数据
 * @param memory 如需知道输出数据所占内存，传入数据起始点的内存数
 * @return result
 */
if (!function_exists('debug')) {
    function debug($data, $mem = '')
    {
        // 定义样式
        $str = '<pre style="display: block;padding: 9.5px;margin: 44px 0 0 0;font-size: 13px;line-height: 1.42857;color: #333;word-break: break-all;word-wrap: break-word;background-color: #F5F5F5;border: 1px solid #CCC;border-radius: 4px;">';
        // 如果是boolean或者null直接显示文字；否则print
        if (is_bool($data)) {
            $show_data = $data ? 'true' : 'false';
        } elseif (is_null($data)) {
            $show_data = 'null';
        } else {
            $show_data = print_r($data, true);
        }
        $str .= $show_data;
        $str .= '</pre>';
        if (!empty($mem)) {
            echo '所选数据块所占内存(mb)：'.(((memory_get_usage() / 1024) / 1024) - ($mem / 1024) / 1024);
            echo '<br>';
        }
        echo '脚本目前所占内存(mb)：'.((memory_get_usage() / 1024) / 1024);
        echo $str;
        exit;
    }
}
