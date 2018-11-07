<?php

/**
 * 日期时间类库
 * User: tangjian
 * Date: 2017/5/17
 * Time: 17:18
 */
class Time
{
    function now()
    {
        return date('Y-m-d H:i:s');
    }

    function today()
    {
        return date('Y-m-d');
    }

    function yesterday()
    {
        return date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
    }

    function tomorrow()
    {
        return date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));
    }

    // 根据时间返回年月日
    function day($time)
    {
        return date('Y-m-d', strtotime($time));
    }

    function last_month()
    {
        return date('Y-m', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
    }

    // 返回时间
    function time_add_hour($hour)
    {
        return date('Y-m-d H:i:s', mktime(date("H") + $hour));
    }


}