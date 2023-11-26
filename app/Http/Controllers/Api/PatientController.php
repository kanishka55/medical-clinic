<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::all();
        return response()->json($patients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($external_patient_id)
    {
        $patient = Patient::where('external_patient_id', $external_patient_id)->first();

        $receipts = Receipt::where('external_patient_id', $external_patient_id)->get();
        $total_receipt_amount = $receipts->sum('amount');
        $first_receipt_date = Carbon::parse($receipts->min('receipt_created_date'))->format('Y-m-d');

        $invoices = Invoice::where('external_patient_id', $external_patient_id)->get();
        $first_invoice_date = Carbon::parse($invoices->min('date'))->format('Y-m-d');

        $appointments = Appointment::where('external_patient_id', $external_patient_id)->get();
        $first_appointment = $appointments->sortBy('appointment_date')->first();
        $first_appointment_id = $first_appointment ? $first_appointment->id : NULL;

        if(!$patient){
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $response = [
            'patient_id' =>$patient->external_patient_id,
            'first_appointment_id' => $first_appointment_id,
            'invoice' => $invoices->pluck('invoice_no'),
            'total_receipts' => $total_receipt_amount,
            'receipts' => $receipts->pluck('receipt_id'),
            'first_receipt_date' => $first_receipt_date,
            'first_invoice_date' => $first_invoice_date,
            'first_appointment_date' => $first_appointment

        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
