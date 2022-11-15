<?php

use Illuminate\Support\Facades\DB;

function random_string($type = 'alnum', $len = 8)
{
    switch ($type) {
        case 'basic':
            return mt_rand();
        case 'alnum':
        case 'numeric':
        case 'nozero':
        case 'alpha':
            switch ($type) {
                case 'alpha':
                    $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;
                case 'alnum':
                    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    break;
                case 'numeric':
                    $pool = '0123456789';
                    break;
                case 'nozero':
                    $pool = '123456789';
                    break;
            }
            return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
        case 'sha1':
            return sha1(uniqid(mt_rand(), TRUE));
    }
}

function currencyIDR($nominal, $symbol = true)
{
    $val = "";
    if ($symbol) {
        $val .= "Rp. ";
    }

    $val .= number_format($nominal, 0, ",", ".");
    return $val;
}

function get_enum_values($table, $field)
{
    $types = DB::select(DB::raw("SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'"));
    preg_match("/^enum\(\'(.*)\'\)$/", $types[0]->Type, $matches);
    $enum = explode("','", $matches[1]);
    return $enum;
}

function lastNomor($prefix, $table, $column)
{

    $result = DB::table('orders')
        ->select($column)
        ->orderBy($column, 'desc')
        ->where($column, 'like', "%$prefix%")->first();
    if ($result != null) {
        return intval(str_replace($prefix, "", $result->$column));
    }
    return 0;
}

function generateOrderNumber()
{
    $prefix = 'KAV' . date('y') . date('m');
    $last_code = lastNomor($prefix, 'order', 'nomor_invoice');
    $new_code = str_pad(($last_code + 1), 4, "0", STR_PAD_LEFT);
    return $prefix . $new_code;
}
