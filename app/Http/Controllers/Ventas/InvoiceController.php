<?php

namespace App\Http\Controllers\Ventas;

use App\Client;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceBody;
use App\ResumeInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{

    public function index()
    {
        //
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
        
        });

        
    }

    public function show(Invoice $invoice)
    {
        //
    }

    public function edit(Invoice $invoice)
    {
        //
    }

    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    public function destroy(Invoice $invoice)
    {
        //
    }
}
