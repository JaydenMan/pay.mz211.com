<?php

//json信息返回
function wap_response($code = '', $msg = '', $data = array(), $type = 'json')
{
    $_rdata = array('code' => $code, 'msg' => $msg, 'data' => $data);
    $_response = \think\Response::create($_rdata, $type)->code(200);
    return $_response;
}

//获取客户端IP
function getClientIp()
{
    $cip = getenv('HTTP_CLIENT_IP');
    $xip = getenv('HTTP_X_FORWARDED_FOR');
    $rip = getenv('REMOTE_ADDR');
    $srip = $_SERVER ['REMOTE_ADDR'];
    if ($cip && strcasecmp($cip, 'unknown')) {
        $onlineip = $cip;
    } elseif ($xip && strcasecmp($xip, 'unknown')) {
        $onlineip = $xip;
    } elseif ($rip && strcasecmp($rip, 'unknown')) {
        $onlineip = $rip;
    } elseif ($srip && strcasecmp($srip, 'unknown')) {
        $onlineip = $srip;
    }
    preg_match('/[\d\.]{7,15}/', $onlineip, $match);
    return $match [0] ? $match [0] : '';
}

//键值串转数组
function query2Array($query)
{
    $retArr = array();
    if (is_string($query) && !empty($query)) {
        $temp = explode('&', $query);
        foreach ($temp as $str) {
            $t = explode('=', $str);
            if (isset($t[0], $t[1])) {
                $retArr[$t[0]] = $t[1];
            }
        }
    }
    return $retArr;
}


//将查询请求串转为数组
function request2Array($request = '')
{
    $retArr = array();
    if (empty($request)) $request = $_SERVER['REQUEST_URI'];
    $parseUrl = parse_url($request);
    if (!empty($parseUrl) && isset($parseUrl['query'])) {
        $query = urldecode($parseUrl['query']);
        $temp = explode('&', $query);
        if (is_array($temp) && !empty($temp)) {
            foreach ($temp as $str) {
                $t = explode('=', $str);
                if (isset($t[0], $t[1])) {
                    $retArr[$t[0]] = $t[1];
                }
            }
        }
    }
    return $retArr;
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function listToTree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

function put($data, $path = 'E:/log.txt')
{
    if (PHP_OS == 'Linux') $path = '/www/wwwroot/pay_mz211_com/log.txt';
    file_put_contents($path, var_export($data, true) . "\r\n", FILE_APPEND);
}


//php获取中文字符拼音首字母
function getFirstCharter($str)
{
    if (empty($str)) {
        return '';
    }
    $fchar = ord($str{0});
    if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{0});
    $s1 = iconv('UTF-8', 'gb2312//TRANSLIT//IGNORE', $str);
    $s2 = iconv('gb2312', 'UTF-8//TRANSLIT//IGNORE', $s1);
    $s = $s2 == $str ? $s1 : $str;
    $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
    if ($asc >= -20319 && $asc <= -20284) return 'A';
    if ($asc >= -20283 && $asc <= -19776) return 'B';
    if ($asc >= -19775 && $asc <= -19219) return 'C';
    if ($asc >= -19218 && $asc <= -18711) return 'D';
    if ($asc >= -18710 && $asc <= -18527) return 'E';
    if ($asc >= -18526 && $asc <= -18240) return 'F';
    if ($asc >= -18239 && $asc <= -17923) return 'G';
    if ($asc >= -17922 && $asc <= -17418) return 'H';
    if ($asc >= -17417 && $asc <= -16475) return 'J';
    if ($asc >= -16474 && $asc <= -16213) return 'K';
    if ($asc >= -16212 && $asc <= -15641) return 'L';
    if ($asc >= -15640 && $asc <= -15166) return 'M';
    if ($asc >= -15165 && $asc <= -14923) return 'N';
    if ($asc >= -14922 && $asc <= -14915) return 'O';
    if ($asc >= -14914 && $asc <= -14631) return 'P';
    if ($asc >= -14630 && $asc <= -14150) return 'Q';
    if ($asc >= -14149 && $asc <= -14091) return 'R';
    if ($asc >= -14090 && $asc <= -13319) return 'S';
    if ($asc >= -13318 && $asc <= -12839) return 'T';
    if ($asc >= -12838 && $asc <= -12557) return 'W';
    if ($asc >= -12556 && $asc <= -11848) return 'X';
    if ($asc >= -11847 && $asc <= -11056) return 'Y';
    if ($asc >= -11055 && $asc <= -10247) return 'Z';
    return null;
}