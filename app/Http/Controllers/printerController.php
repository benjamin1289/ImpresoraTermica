<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as IlluminateResponse;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Mike42\Escpos\Printer; 
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class printerController extends Controller{
 
	public function printer(){
		$computerName = gethostname();
		$printerName = 'LR2000';
		try {
            $connector = new WindowsPrintConnector($printerName);
            $printer = new Printer($connector);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer -> text("Hello World!Hello World!Hello World!\n");
            $printer -> cut();

            $printer -> close();

        } catch(Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
	}


}
