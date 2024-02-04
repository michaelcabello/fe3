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

class SunatService
{
    public $invoice, $company;
    public $voucher;

    public function getSee()
    {
        // configuraremos el certificado digital, la ruta del servicio y las credenciales (Clave SOL) a utilizar:
        $see = new See();
        $see->setCertificate(Storage::get($this->company->cert_path)); //le pasamos la ruta del certificado, da como resultado el contenido del certificado
        $see->setService($this->company->production ? SunatEndpoints::FE_PRODUCCION : SunatEndpoints::FE_BETA); //le indicamos si es beta o produccion
        $see->setClaveSOL($this->company->ruc, $this->company->sol_user, $this->company->sol_pass); //le pasamos los datos de la clave sol usurio secundario
        return $see; //retornamos todos los valores
    }

    public function setInvoice()
    {
        $this->voucher = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion($this->invoice->tipoOperacion) // Venta - Catalog. 51
            ->setTipoDoc($this->invoice->tipoDoc) // Factura - Catalog. 01
            ->setSerie($this->invoice->serie)
            ->setCorrelativo($this->invoice->correlativo) // Zona horaria: Lima
            ->setFechaEmision($this->invoice->fechaEmision) // Zona horaria: Lima
            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
            ->setTipoMoneda($this->invoice->tipoMoneda) // Sol - Catalog. 02
            ->setCompany($this->getCompany())
            ->setClient($this->getClient())

            //MtoOper
            ->setMtoOperGravadas($this->invoice->mtoOperGravadas)
            ->setMtoOperExoneradas($this->invoice->mtoOperExoneradas)
            ->setMtoOperInafectas($this->invoice->mtoOperInafectas)
            ->setMtoOperExportacion($this->invoice->mtoOperExportacion)
            ->setMtoOperGratuitas($this->invoice->mtoOperGratuitas)

            //Impuestos
            ->setMtoIGV($this->invoice->mtoIGV)
            ->setMtoIGVGratuitas($this->invoice->mtoIGVGratuitas)
            ->setIcbper($this->invoice->icbper)
            ->setTotalImpuestos($this->invoice->totalImpuestos)

            //Totales
            ->setValorVenta($this->invoice->valorVenta)
            ->setSubTotal($this->invoice->subTotal)
            ->setRedondeo($this->invoice->redondeo)
            ->setMtoImpVenta($this->invoice->mtoImpVenta)

            //Productos
            ->setDetails($this->getSaleDetails())

            //Leyendas
            ->setLegends($this->getLegends());
    }


}
