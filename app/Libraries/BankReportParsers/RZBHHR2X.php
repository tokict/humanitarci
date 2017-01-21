<?php
namespace App\Libraries\BankReportParsers;

use Maatwebsite\Excel\Facades\Excel;

/**
 * Created by PhpStorm.
 * User: tino
 * Date: 1/11/17
 * Time: 12:31 PM
 */
class RZBHHR2X
{
    protected $data = [];

    public function __construct($file)
    {

        Excel::load($file, function ($reader)  {
            $reader->noHeading();
            $rows = $reader->skip(7)->get();
            foreach ($rows as $key =>  $row) {
                $r = $row->toArray();
                if(!$r[6] ||$key == $rows->count() || !$r[5] ){
                    continue;
                }

               /* $this->data[] = [
                    'date' => $r[2],
                    'description' => $r[4],
                    'payee' => $r[5],
                    'amount' => $r[6],
                ];*/
            }
        });

    }

    public function getData()
    {
        return $this->data;
    }
}