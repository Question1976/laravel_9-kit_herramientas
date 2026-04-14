<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\Productos;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Http;


class UtilesController extends Controller
{
    /**
     * Mostrar vista - Menú ORM
     * http://herramientas.test/utiles
     */
    public function utiles_inicio() {
        return view('utiles.home');             // mostrar vista
    }

    /**
     * Reportes PDF
     * http://herramientas.test/utiles/pdf
     */
    public function utiles_pdf() {
        // Instanciar la librería mPDF (crea un nuevo documento PDF en memoria)
        $mpdf = new \Mpdf\Mpdf();

        // Obtener la ruta absoluta de la imagen
        $logoPath = public_path('images/logo.jpg');

        // Escribir contenido HTML dentro del PDF
        // mPDF convierte HTML/CSS básico a formato PDF
        // Aquí puedes poner tablas, imágenes, estilos, etc.
        $html = '
            <h1 style="text-align: center;">Reporte en PDF desde Laravel</h1>
            <p style="text-align: center;">Texto e imagen con formato centrado</p>
            <div style="text-align: center; margin: 20px 0;">
                <img src="' . $logoPath . '" alt="Logo" style="width: 100px; height: auto;">
            </div>
        ';

        $mpdf->WriteHTML($html);

        // Generar y enviar el PDF al navegador
        // Por defecto: lo abre en el navegador (inline)
        // Opciones: $mpdf->Output('archivo.pdf', 'D') → forzar descarga
        $mpdf->Output();
    }

    /**
     * Reportes Excel
     * http://herramientas.test/utiles/excel
     */
    public function utiles_excel() {
        $helper = new Sample();

        if ($helper->isCli()) {
            $helper->log('This example should only be run from a Web Browser' . PHP_EOL);

            return;
        }

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Salvador Belloso Santos')
            ->setLastModifiedBy('Tamila.cl')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Excel creado con PHP.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');
        $datos = Productos::orderBy('id', 'desc')->get();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Categoría')
            ->setCellValue('C1', 'Nombre')
            ->setCellValue('D1', 'Precio')
            ->setCellValue('E1', 'Stock')
            ->setCellValue('F1', 'Descripción')
            ->setCellValue('G1', 'Fecha');
        $i = 2;

        // Generar filas de forma dinámica
        foreach($datos as $dato) {            
            $spreadsheet->getActiveSheet()
            ->setCellValue('A'.$i, $dato->id)
            ->setCellValue('B'.$i, $dato->categorias->nombre)
            ->setCellValue('C'.$i, $dato->nombre)
            ->setCellValue('D'.$i, $dato->precio)
            ->setCellValue('E'.$i, $dato->stock)
            ->setCellValue('F'.$i, $dato->descripcion)
            ->setCellValue('G'.$i, Helpers::invierte_fecha($dato->fecha));
            $i++;
        }        

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Hoja 1');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte_'.time().'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    /**
    * Integración API externa privada
    * http://herramientas.test/utiles/cliente-rest
    */    
    public function utiles_cliente_rest() {
        // Paso 1: Obtener token (con caché para que no expire)
        $token = cache()->remember('api_tamila_token', 82800, function() {
            // Login a la API para obtener token
            $response = Http::post('https://www.api.tamila.cl/api/login', [
                'correo' => 'info@tamila.cl',
                'password' => 'p2gHNiENUw'
            ]);
            
            // Retornar el token o null si falla
            return $response->json()['token'] ?? null;
        });

        // Paso 2: Hacer la petición con el token de autorización
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('https://www.api.tamila.cl/api/productos');

        // Datos en un objeto
        $datos = $response->object();
        $json = $response->body();
        $status = $response->status();
        $headers = $response->headers();

        // Mostrar vista y pasarle datos
        return view('utiles.cliente_rest', compact('datos', 'status', 'headers', 'json'));
    }
    
    /**
    * Integración API externa publica
    * http://herramientas.test/utiles/cliente-rest-publica
    */  
    public function utiles_cliente_rest_publica() {
        // Petición API pública
        $response = Http::get('https://jsonplaceholder.typicode.com/users');
    
        // Obtener datos
        $users = $response->json();
        $status = $response->status();

        // Mostrar vista y pasarle datos
        return view('utiles.cliente_rest_publica', compact('users', 'status'));
    }
   
}