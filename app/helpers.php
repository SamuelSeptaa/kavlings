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

function getDayName($day_of_week)
{
    switch ($day_of_week) {
        case 1:
            return 'Senin';
            break;

        case 2:
            return 'Selasa';
            break;

        case 3:
            return 'Rabu';
            break;

        case 4:
            return 'Kamis';
            break;

        case 5:
            return 'Jumat';
            break;

        case 6:
            return 'Sabtu';
            break;

        case 0:
            return 'Minggu';
            break;

        default:
            return 'Senin';
            break;
    }
}

function getMonthName($month)
{
    switch ($month) {
        case 1:
            return 'Januari';
            break;

        case 2:
            return 'Februari';
            break;

        case 3:
            return 'Maret';
            break;

        case 4:
            return 'April';
            break;

        case 5:
            return 'Mei';
            break;

        case 6:
            return 'Juni';
            break;

        case 7:
            return 'Juli';
            break;

        case 8:
            return 'Agustus';
            break;

        case 9:
            return 'September';
            break;

        case 10:
            return 'Oktober';
            break;

        case 11:
            return 'November';
            break;

        case 12:
            return 'Desember';
            break;

        default:
            # code...
            break;
    }
}

function parseTanggal($date)
{
    date_default_timezone_set('Asia/Jakarta');
    $day_name = getDayName(date('w', strtotime($date)));
    $day = date('d', strtotime($date));
    $month = getMonthName(date('m', strtotime($date)));
    $year = date('Y', strtotime($date));

    $hIs = date('H:i:s', strtotime($date));
    return "$day_name, $day $month $year $hIs";
}
