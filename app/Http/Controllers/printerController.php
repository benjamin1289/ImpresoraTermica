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
 
    public function imprimeticket(Request $request){
        $datos = $request->all();
        $printerName = 'LR2000';
        try {
            $connector = new WindowsPrintConnector($printerName);
            $printer = new Printer($connector);
            $count = count($datos);
            for ($i=0; $i < $count; $i++) {
                $row = json_decode( $datos[$i] );
                if($row->text == "-1"){
                    $printer -> feed(1);;
                }else{
                    if( $row->align == 0 ){//JUSTIFY_LEFT
                        $printer->setJustification(Printer::JUSTIFY_LEFT);
                    }else if( $row->align == 1){//JUSTIFY_CENTER
                        $printer->setJustification(Printer::JUSTIFY_CENTER);
                    }else{//JUSTIFY_RIGHT
                        $printer->setJustification(Printer::JUSTIFY_RIGHT);
                    }
                    $printer -> text($row->text."\n");    
                }
            }
            $printer -> cut();
            $printer -> close();
            $data = ['status'  =>200,
                 'message' => "Success",
                 'data'    => []
             ];

            return $this->respond("Impresion Correcta", []);
        } catch(Exception $e) {
            return $this->respondInternalError("Impresion Correcta", $e);
        }


    }

    public function ticket(Request $request){
        $datos = $request->all();
        $printerName = 'LR2000';
        try {
            $connector = new WindowsPrintConnector($printerName);
            $printer = new Printer($connector);
            $count = count($datos);
            for ($i=0; $i < $count; $i++) {
                $row = $datos[$i];
                $tmp = trim($row);;
                if(trim($tmp)==""){
                    $printer -> feed(1);;
                }else{
                    //echo $row."\t start: ".$row[0]."\t left: ".$row[ strlen( $row ) -1]."\n";
                    if( $row[0] == " " && $row[ strlen( $row ) -1] == " "){//JUSTIFY_CENTER
                        $printer->setJustification(Printer::JUSTIFY_CENTER);
                    }else if( $row[0] != " " && $row[ strlen($row ) -1] == " "){//JUSTIFY_LEFT
                        $printer->setJustification(Printer::JUSTIFY_LEFT);
                    }else{//JUSTIFY_RIGHT
                        $printer->setJustification(Printer::JUSTIFY_RIGHT);
                    }
                    $printer -> text($row."\n");    
                }
            }
            $printer -> cut();
            $printer -> close();
            $data = ['status'  =>200,
                 'message' => "Success",
                 'data'    => []
             ];

            return $this->respond("Impresion Correcta", []);
        } catch(Exception $e) {
            return $this->respondInternalError("Impresion Correcta", $e);
        }


    }

    public function printertest(){
        //$computerName = gethostname();
        $printerName = 'LR2000';
        try {
            $connector = new WindowsPrintConnector($printerName);
            $printer = new Printer($connector);
            $datos = [
                        "    Centrado    ",
                        "Izquierda                ",
                        "           Derecha"
                    ];
            $count = count($datos);
            for ($i=0; $i < $count; $i++) {
                $row = $datos[$i];
                $space = trim($row);
                if($space==""){
                    $printer -> feed(1);;
                }else{
                    //echo $count."\t init:\t".$row[0]."\t left:\t".$row[ strlen( $row ) -1]."\n";
                    if( $row[0] == " " && $row[ strlen( $row ) -1] == " "){//JUSTIFY_CENTER
                        $printer->setJustification(Printer::JUSTIFY_CENTER);
                    }else if( $row[0] != " " && $row[ strlen($row ) -1] == " "){//JUSTIFY_LEFT
                        $printer->setJustification(Printer::JUSTIFY_LEFT);
                    }else{//JUSTIFY_RIGHT
                        $printer->setJustification(Printer::JUSTIFY_RIGHT);
                    }
                    $printer -> text($row."\n");    
                }
            }
            $printer -> cut();

            $printer -> close();
            $data = ['status'  =>200,
                 'message' => "Success",
                 'data'    => []
             ];

            return $this->respond("Impresion Correcta", []);
        } catch(Exception $e) {
            return $this->respondInternalError("Impresion Correcta", $e);
        }
    }


    public function printertestip(){
        //$computerName = gethostname();
        $printerip = '192.168.0.190';
        try {
            $connector = new NetworkPrintConnector($printerip, 9100);
            $printer = new Printer($connector);
            $datos = [
                        "                  Center                  ",
                        "Alineacion a la izquierda                ",
                        "                  Alineacion a la derecha"
                    ];
            $count = count($datos);
            for ($i=0; $i < $count; $i++) {
                $row = $datos[$i];

                if(trim($row)==""){
                    $printer -> feed(1);;
                }else{
                    if( $row[0] == " " && $row[ strlen( $row ) -1] == " "){//JUSTIFY_CENTER
                        $printer->setJustification(Printer::JUSTIFY_CENTER);
                    }else if( $row[0] != " " && $row[ strlen($row ) -1] == " "){//JUSTIFY_LEFT
                        $printer->setJustification(Printer::JUSTIFY_LEFT);
                    }else{//JUSTIFY_RIGHT
                        $printer->setJustification(Printer::JUSTIFY_RIGHT);
                    }
                    $printer -> text($row."\n");    
                }
            }
            $printer -> cut();

            $printer -> close();
            $data = ['status'  =>200,
                 'message' => "Success",
                 'data'    => []
             ];

            return $this->respond("Impresion Correcta", []);
        } catch(Exception $e) {
            return $this->respondInternalError("Impresion Correcta", $e);
        }
    }


    public function imprimeticketip(Request $request){
        $params = $request->all();
		$datos = $params['ticket'];// $request->all();
		$printerip = $params['ip'];
		// echo 'IP: '.$datos['ip'];
		// print_r( json_decode($datos, true) );
		$datos = json_decode($datos, true);
        try {
            $connector = new NetworkPrintConnector($printerip, 9100);
            $printer = new Printer($connector);
            $count = count($datos);
            for ($i=0; $i < $count; $i++) {
                $row = $datos[$i];// json_decode( $datos[$i] );
                if($row['text'] == "-1"){
                    $printer -> feed(1);;
                }else{
                    if( $row['align'] == 0 ){//JUSTIFY_LEFT
                        $printer->setJustification(Printer::JUSTIFY_LEFT);
                    }else if( $row['align'] == 1){//JUSTIFY_CENTER
                        $printer->setJustification(Printer::JUSTIFY_CENTER);
                    }else{//JUSTIFY_RIGHT
                        $printer->setJustification(Printer::JUSTIFY_RIGHT);
                    }
                    $printer -> text($row['text']."\n");    
                }
            }
            $printer -> cut();
            $printer -> close();
            $data = ['status'  =>200,
                 'message' => "Success",
                 'data'    => []
             ];

            return $this->respond("Impresion Correcta", []);
        } catch(Exception $e) {
            return $this->respondInternalError("Impresion Correcta", $e);
        }


    }


     /**
     * Retorna una respuesta con código '400' Un error en la petición
     *
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Error 404', $error = [])
    {
        $data = [
                'status'  => 404,
                'message' => $message,
                'data'    => $error
                ];

        $response = new JsonResponse();

        $response->setData($error);

        $response->setStatusCode(404);
        
        return $response;
    }

    /**
     * Generar una respuesta a una petición al servidor, por defecto código de status es 200(OK)
     *
     * @param $message
     * @param array $data
     * @param array $headers
     * @return mixed
     */ 
    public function respond($message,$data = [])
    {
        $data = ['status'  => 200,
                 'message' => $message,
                 'data'    => $data];

        $response = new JsonResponse();

        $response->setData($data);

        $response->setStatusCode(200);

        return $response;
    }


}
