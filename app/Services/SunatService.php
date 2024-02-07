<?php

namespace App\Services;

use DateTime;
use Greenter\See; //importar
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\Legend;
use Greenter\Report\HtmlReport;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Despatch\Driver;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Despatch\Vehicle;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Direction;
use Illuminate\Support\Facades\Storage;
use App\Models\Company as ModelsCompany;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Report\Resolver\DefaultTemplateResolver;
use Greenter\Report\XmlUtils;

class SunatService
{
    public $invoice, $company;
    public $see;
    public $voucher;
    public $result;


    public function __construct($invoice, $company)
    {
        $this->invoice = $invoice;
        $this->company = $company;
    }

    public function getSee()
    {
        // configuraremos el certificado digital, la ruta del servicio y las credenciales (Clave SOL) a utilizar:
        /* $see = new See();
        $see->setCertificate(Storage::get($this->company->certificate_path)); //le pasamos la ruta del certificado, da como resultado el contenido del certificado
        $see->setService($this->company->production ? SunatEndpoints::FE_PRODUCCION : SunatEndpoints::FE_BETA); //le indicamos si es beta o produccion
        $see->setClaveSOL($this->company->ruc, $this->company->soluser, $this->company->solpass); //le pasamos los datos de la clave sol usurio secundario
        return $see; //retornamos todos los valores */
        $endpoint = $this->company->production ? SunatEndpoints::FE_PRODUCCION : SunatEndpoints::FE_BETA;

        $this->see = new See();
        $this->see->setCertificate(Storage::get("certificates/certificate_1.pem"));
        $this->see->setService($endpoint);
        $this->see->setClaveSOL($this->company->ruc, $this->company->soluser, $this->company->solpass);
    }

    public function setInvoice()
    {
        $this->voucher = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion($this->invoice['tipoOperacion']) // Venta - Catalog. 51

            ->setTipoDoc($this->invoice['tipoDoc']) // Factura - Catalog. 01
            ->setSerie($this->invoice['serie'])
            ->setCorrelativo($this->invoice['correlativo']) // Zona horaria: Lima
            //->setFechaEmision($this->invoice['fechaEmision']) // Zona horaria: Lima
            ->setFechaEmision(new \DateTime($this->invoice['fechaEmision']))
            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
            ->setTipoMoneda($this->invoice['tipoMoneda']) // Sol - Catalog. 02
            ->setCompany($this->getCompany())
            ->setClient($this->getClient())

            //MtoOper
            ->setMtoOperGravadas($this->invoice['mtoOperGravadas'])
            ->setMtoOperExoneradas($this->invoice['mtoOperExoneradas'])
            ->setMtoOperInafectas($this->invoice['mtoOperInafectas'])
            ->setMtoOperExportacion($this->invoice['mtoOperExportacion'])
            ->setMtoOperGratuitas($this->invoice['mtoOperGratuitas'])

            //Impuestos
            ->setMtoIGV($this->invoice['mtoIGV'])
            ->setMtoIGVGratuitas($this->invoice['mtoIGVGratuitas'])
            ->setIcbper($this->invoice['icbper'])
            ->setTotalImpuestos($this->invoice['totalImpuestos'])

            //Totales
            ->setValorVenta($this->invoice['valorVenta'])
            ->setSubTotal($this->invoice['subTotal'])
            ->setRedondeo($this->invoice['redondeo'])
            ->setMtoImpVenta($this->invoice['mtoImpVenta'])

            //Productos
            ->setDetails($this->getSaleDetails())

            //Leyendas
            ->setLegends($this->getLegends());
    }

    public function getClient()
    {
        return (new Client())
            ->setTipoDoc($this->invoice['client']['tipoDoc'])
            ->setNumDoc($this->invoice['client']['numDoc'])
            ->setRznSocial($this->invoice['client']['rznSocial'])
            ->setAddress(
                (new Address())
                    ->setDireccion($this->invoice['client']['address']['direccion'])
            );
    }

    public function getCompany()
    {
        return (new Company())
            ->setRuc($this->invoice['company']['ruc'])
            ->setRazonSocial($this->invoice['company']['razonSocial'])
            ->setNombreComercial($this->invoice['company']['nombreComercial'])
            ->setAddress(
                (new Address())
                    ->setUbigueo($this->invoice['company']['address']['ubigeo'])
                    ->setDepartamento($this->invoice['company']['address']['departamento'])
                    ->setProvincia($this->invoice['company']['address']['provincia'])
                    ->setDistrito($this->invoice['company']['address']['distrito'])
                    ->setUrbanizacion('-')
                    ->setDireccion($this->invoice['company']['address']['direccion'])
            );

        /* return (new \Greenter\Model\Company\Company())
                ->setRuc('20609278235')
                ->setRazonSocial('GREENTER S.A.C.'); */
    }

    public function getSaleDetails()
    {
        $details = [];

        foreach ($this->invoice['details'] as $item) {

            $details[] = (new SaleDetail())
                ->setCodProducto($item['codProducto'])
                ->setUnidad($item['unidad'])
                ->setDescripcion($item['descripcion'])
                ->setCantidad($item['cantidad'])
                ->setMtoValorGratuito($item['mtoValorGratuito'])
                ->setMtoValorUnitario($item['mtoValorUnitario'])
                ->setMtoBaseIgv($item['mtoBaseIgv'])
                ->setPorcentajeIgv($item['porcentajeIgv'])
                ->setIgv($item['igv'])
                ->setFactorIcbper($item['factorIcbper'])
                ->setIcbper($item['icbper'])
                ->setTipAfeIgv($item['tipAfeIgv'])
                ->setTotalImpuestos($item['totalImpuestos'])
                ->setMtoValorVenta($item['mtoValorVenta'])
                ->setMtoPrecioUnitario($item['mtoPrecioUnitario']);
        }

        return $details;
    }


    public function getLegends()
    {
        $legends = [];

        foreach ($this->invoice['legends'] as $legend) {

            $legends[] = (new Legend())
                ->setCode($legend['code']) // Catalog. 52
                ->setValue($legend['value']);
        }

        return $legends;
    }



    //Enviar a Sunat
    public function send()
    {

        $this->result = $this->see->send($this->voucher);
        $this->invoice['send_xml'] = true;
        $this->invoice['sunat_success'] = $this->result->isSuccess();
        //$this->invoice->save();

        // Guardar XML firmado digitalmente.
        $xml = $this->see->getFactory()->getLastXml();
        $this->invoice['hash'] = (new XmlUtils())->getHashSign($xml);
        $this->invoice['xml_path'] = 'invoices/xml/' . $this->voucher->getName() . '.xml';
        Storage::put($this->invoice['xml_path'], $xml, 'public');


        // Verificamos que la conexión con SUNAT fue exitosa.
        if (!$this->invoice['sunat_success']) {

            $this->invoice['sunat_error'] = [
                'code' => $this->result->getError()->getCode(),
                'message' => $this->result->getError()->getMessage()
            ];
            //$this->invoice->save();

            session()->flash('flash.sweetAlert', [
                'icon' => 'error',
                'title' => 'Codigo Error: ' . $this->invoice['sunat_error']['code'],
                'text' => $this->invoice['sunat_error']['message']
            ]);

            return;
        }


        // Guardamos el CDR
        $this->invoice['sunat_cdr_path'] = "invoices/cdr/R-{$this->voucher->getName()}.zip";
        Storage::put($this->invoice['sunat_cdr_path'], $this->result->getCdrZip(), 'public');
        //$this->invoice->save();

        //Lectura del CDR
        $this->readCdr();


        dd($this->invoice);
    }

    //Lectura del CDR
    public function readCdr()
    {
        $cdr = $this->result->getCdrResponse();

        $this->invoice['cdr_code'] = (int)$cdr->getCode();
        $this->invoice['cdr_notes'] = count($cdr->getNotes()) ? $cdr->getNotes() : null;
        $this->invoice['cdr_description'] = $cdr->getDescription();

        // $this->invoice->save();

        if ($this->invoice['cdr_code'] === 0) {

            session()->flash('flash.sweetAlert', [
                'icon' => 'success',
                'title' => 'ESTADO: ACEPTADA',
                'text' => $this->invoice['cdr_notes'] ? 'OBSERVACIONES: ' . implode(', ', $cdr->getNotes()) : null,
                'footer' => $this->invoice['cdr_description'],
            ]);
        } else if ($this->invoice['cdr_code'] >= 2000 && $this->invoice['cdr_code'] <= 3999) {

            session()->flash('flash.sweetAlert', [
                'icon' => 'error',
                'title' => 'ESTADO: RECHAZADA',
                'footer' => $this->invoice['cdr_description'],
            ]);
        } else {
            /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
            /*code: 0100 a 1999 */
            session()->flash('flash.sweetAlert', [
                'icon' => 'error',
                'title' => 'Excepción',
                'footer' => $this->invoice['cdr_description'],
            ]);
        }
    }
}
