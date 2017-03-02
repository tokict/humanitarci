<?php
namespace App\Libraries\BankReportParsers;

use Maatwebsite\Excel\Facades\Excel;

/**
 * Created by PhpStorm.
 * User: tino
 * Date: 1/11/17
 * Time: 12:31 PM
 */
class PBZGHR2X
{
    protected $data = [];

    public function __construct($file)
    {

        //Parse pdf file and build necessary objects .
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($file);

        // Retrieve all pages from the pdf file.
        $pages = $pdf->getPages();


        // Loop over each page to extract text.
        foreach ($pages as $key => $page) {
            $r = $this->parseRows($this->getRows($page->getText(), $key));
            foreach ($r as $item) {
                $this->data[] = $item;
            }
        }




    }

    public function getData()
    {
        return $this->data;
    }

    private function getRows($data, $pageNr)
    {

        $rows = [];
        $start = ($pageNr == 1)? 17: 34;


        $lines = explode("\n", $data); //dd($lines);
        $ret = "";
        //dd($lines);
        foreach ($lines as $key => $line) {

            $line = trim($line);
            if(strpos($line, '*** KRAJ IZVATKA ***') !== false
            || count($rows) >= 8){
                break;
            }
            if($key >= $start) {
                if($line == ''){
                    $line = '---';
                }
                //We came to the amount
                if($key == $start +23){
                    $ret .= $line;
                    $rows[] = $ret;
                    $ret = '';
                    $start = $key + 1;



                }else {
                        $ret .= $line . "||";


                }
            }
        }
        return $rows;
    }

    private function parseRows($rows){
        $ret = [];

        foreach ($rows as $row) {
            $parts = explode("||", $row);
            if($parts[count($parts) - 3] != "---"){
                continue;
            }

            $d = [
                'id' => $parts[0],
                'iban' => $parts[1],
                'name' => $parts[2],
                'address' => $parts[3],
                'city' => $parts[4],
                'bank_reference' => $parts[6],
                'payee_reference' => $parts[8],
                'receiver_reference' => $parts[9],
                'description' => $parts[11].$parts[12],
                'date' => $parts[19],
                'amount' => $parts[22],
            ];
            $ret[] = $d;

        }

        return $ret;
    }
}