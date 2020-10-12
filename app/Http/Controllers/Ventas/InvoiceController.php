<?php

namespace App\Http\Controllers\Ventas;

use App\Client;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceBody;
use App\PaymentMethod;
use App\ResumeInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{

    public function index()
    {
        $invoices = Invoice::with(['cliente','payment_method'])->get();
        return response()->json([
            'rows'=>$invoices
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

     return  DB::transaction(function() use($request){
            
        $client = new Client();
        if ($request->has('usuario_final')) {
            $client = Client::find(1);
        }else{
            $client->fill($request->all());
            $client->save();
        }
        $invoice = new Invoice();
        $invoice->fill($request->all());
        $invoice->client_id = $client->id;
        $invoice->total = $request->total_factura;
        $invoice->save();
        
        return 'ok';
        });

        
    }

    public function show(Invoice $invoice)
    {

        $payment = PaymentMethod::find($invoice->payment_method_id);

        return view('Ventas.Comprobantes.show')->with(["invoice"=>$invoice,"payment"=>$payment]);
    }

    public function edit(Invoice $invoice)
    {
  
    }

    public function update(Request $request, Invoice $invoice)
    {
       $request->status = $request->status == 'activo'? 'inactivo':'activo';
      
        $invoice->update([
            'status'=>$request->status
        ]);
        return response($invoice,200);
    }

    public function destroy(Invoice $invoice)
    {
        //
    }

    public function get_invoice_products(Invoice $invoice)
    {
        $products = InvoiceBody::with(['product'])->where('invoice_id',$invoice->id)->get();
        return response()->json([
            'rows'=>$products
        ]);
    }
}
