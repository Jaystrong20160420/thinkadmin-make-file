<?php

namespace ThinkadminMakeFile\Consts;

class OptionConst
{
    /**
     * 模式--mode layui、static
     * -m --layui、  static
     */
    public const MODE_LAYUI = 'layui';
    public const MODE_STATIC = 'static';

    /**
     * @var string[] 列表：模式
     */
    public static $modeList = [
        self::MODE_LAYUI,
        self::MODE_STATIC,
    ];

    /**
     * 操作： 1是 0否
     */
    public const YES = 1;
    public const NO = 0;

    /**
     * @var int[] 列表： 1是 0否
     */
    public static $yesNoList = [
        self::YES,
        self::NO,
    ];
}