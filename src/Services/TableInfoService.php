<?php

namespace ThinkadminMakeFile\Services;
use think\facade\Db;

class TableInfoService
{
    protected $connection;

    public function __construct()
    {
        $this->connection = config('database.default');
    }

    /**
     * 获取表名、字段信息
     *
     * @param string $tableName
     * @return array
     */
    public function getTableInfo(string $tableName)
    {
        $tablePrefix = config('database.connections.' . $this->connection . '.prefix') ?? '';

        if (!empty($tablePrefix) && strpos($tableName, $tablePrefix) === false) {
            $tableName = $tablePrefix . $tableName;
        }

        $columns = $this->getColumns($tableName);

        $tableInfo = [
            'table_name' => $tableName,
            'table_comment' => $this->getTableComment($tableName),  // 获取表的注释
            'columns' => []
        ];

        // 遍历字段信息
        foreach ($columns as $column) {
            $tableInfo['columns'][] = [
                'name' => $column['column_name'],
                'type' => $column['column_type'],
                'comment' => $column['column_comment'] ?: '无'
            ];
        }

        return $tableInfo;
    }

    /**
     * 获取表的字段信息
     *
     * @param $tableName
     * @return mixed
     */
    public function getColumns($tableName)
    {
        $columns = Db::query("
    SELECT 
        c.column_name AS COLUMN_NAME,
        c.udt_name AS COLUMN_TYPE,  -- 使用 udt_name 获取字段类型
        pgd.description AS COLUMN_COMMENT -- 获取字段注释
    FROM 
        information_schema.columns c
    LEFT JOIN 
        pg_catalog.pg_class t ON c.table_name = t.relname
    LEFT JOIN 
        pg_catalog.pg_namespace n ON t.relnamespace = n.oid
    LEFT JOIN 
        pg_catalog.pg_attribute a ON a.attrelid = t.oid AND a.attname = c.column_name
    LEFT JOIN 
        pg_catalog.pg_description pgd ON pgd.objoid = a.attrelid AND pgd.objsubid = a.attnum
    WHERE 
        c.table_schema = :schema 
        AND c.table_name = :table
", [
            'schema' => 'public',  // 你的数据库schema，通常为public
            'table'  => $tableName
        ]);

        return $columns;
    }

    /**
     * 获取表名的注释
     *
     * @param $tableName
     * @return string
     */
    private function getTableComment($tableName)
    {
        // 执行查询以获取表的注释
        $result = Db::query("
        SELECT
            pgd.description AS table_comment
        FROM 
            pg_catalog.pg_class c
        JOIN 
            pg_catalog.pg_namespace n ON n.oid = c.relnamespace
        LEFT JOIN 
            pg_catalog.pg_description pgd ON pgd.objoid = c.oid AND pgd.objsubid = 0
        WHERE 
            c.relname = :table 
            AND n.nspname = :schema
    ", [
            'table'  => $tableName,
            'schema' => 'public',  // 默认 schema，通常为 public
        ]);

        // 如果有结果，返回注释，否则返回空字符串或其他标识
        return isset($result[0]['table_comment']) ? $result[0]['table_comment'] : '';
    }

}