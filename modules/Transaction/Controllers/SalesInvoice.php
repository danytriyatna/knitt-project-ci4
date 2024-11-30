<?php

namespace Modules\Transaction\Controllers;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use Modules\Transaction\Models\ProductionModel;
use Modules\Transaction\Models\WalkorderModel;
use Modules\Transaction\Models\SalesOrderModel;
use Modules\Transaction\Models\SampleModel;
use Modules\Transaction\Models\DeliveryModel;
use Modules\Referensi\Models\ProsesProduksiModel;
use Modules\Referensi\Models\KonsumenModel;
use Modules\Referensi\Models\UkuranModel;
use Modules\Referensi\Models\WarnaModel;

class SalesInvoice extends BaseController
{
  protected $views = '\Modules\Transaction\Views';
  protected $urlv  = 'trans/delivery-order';

  protected $mProduksi;
  protected $mSample;
  protected $mSalesOrder;
  protected $mWalkorder;
  protected $mPproduksi;
  protected $mDelivery;
  protected $mkonsumen;
  protected $mUkuran;
  protected $mWarna;


  function __construct()
  {
    $this->MOD_ALIAS   = "MOD_TRANSAKSI_DELIVERY";
    $this->mProduksi   = new ProductionModel();
    $this->mSample     = new SampleModel();
    $this->mSalesOrder = new SalesOrderModel();
    $this->mWalkorder  = new WalkorderModel();
    $this->mPproduksi  = new ProsesProduksiModel();
    $this->mDelivery   = new DeliveryModel();
    $this->mkonsumen   = new KonsumenModel();
    $this->mUkuran     = new UkuranModel();
    $this->mWarna      = new WarnaModel();
  }

  

  public function index()
  {
    $this->data['titlehead'] = "Sales Invoice";
    
    return view($this->views . '\sales_invoice_list', $this->data);
  }

  public function form()
  {
    $this->data['titlehead'] = "Form Sales Invoice";

    return view($this->views . '\sales_invoice_form', $this->data);
  }
  
}
