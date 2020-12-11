<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * view mit der liste zurückgeben
     * neuen View erstellen - mit Blade-Syntax anzeigen
     *
     * Daten selektieren
     *
     *
     * Daten im with-Methodencall die Daten einfügen
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $invoiceData = Invoice::all();

        return view('invoice')->with('invoiceData', $invoiceData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Zeigt den View zum Erstellen eines Datensatzes an

        return view('invoiceedit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //fügt einen neuen Datensatz ein
        // über das Model zugreifen, anlegen und speichern

        $invoice = new Invoice;
        $invoice->Name = $request->name;
        $invoice->PriceNet = $request->pricenet;
        $invoice->PriceGross = $request->pricegross;
        $invoice->Vat = $request->vat;
        $invoice->UserClearing = "unknown";
        $invoice->save();
        return redirect()->action([InvoiceController::class, 'index']); //oder redirect()->route('invoice')
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return view('invoiceshow')->with('invoice', $invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //Zeigt den View zum Bearbeiten eines Datensatzes an
        return view('invoiceedit')->with('invoice', $invoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //Datensatz aktualiseren
        //Prüfen ob Datensatz noch existiert (in Transaktion)
        DB::beginTransaction();
        $invoice->Name = $request->name;
        $invoice->PriceNet = $request->pricenet;
        $invoice->PriceGross = $request->pricegross;
        $invoice->Vat = $request->vat;

        if (Invoice::where("id", $invoice->id)->exists()) {
            $invoice->save();
            DB::commit();
        } else {
            DB::rollBack();
        }
        return redirect()->action([InvoiceController::class, 'index']); //oder redirect()->route('invoice')
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return $this::index(); //oder redirect()->route('invoice')
    }
}
