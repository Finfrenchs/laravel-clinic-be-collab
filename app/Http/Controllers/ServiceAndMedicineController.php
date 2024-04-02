<?php

namespace App\Http\Controllers;

use App\Models\ServiceAndMedicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceAndMedicineController extends Controller
{
    //index
    public function index(Request $request)
    {
        $service_and_medicines = DB::table('service_and_medicines')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.service_and_medicine.index', compact('service_and_medicines'));
    }

    //create
    public function create()
    {
        return view('pages.service_and_medicine.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|integer',
            'quantity' => 'nullable|integer',
        ]);

        $serviceMedicine = new ServiceAndMedicine;
        $serviceMedicine->name = $request->name;
        $serviceMedicine->category = $request->category;
        $serviceMedicine->price = $request->price;
        // Set quantity only if it's provided
        if ($request->has('quantity')) {
            $serviceMedicine->quantity = $request->quantity;
        }
        $serviceMedicine->save();

        return redirect()->route('services_and_medicines.index')
            ->with('success', 'Service and Medicine created successfully.');
    }

    //show
    public function show($id)
    {
        $serviceAndMedicine = ServiceAndMedicine::findOrFail($id);
        return view('pages.service_and_medicines.show', compact('service_and_medicines'));
    }

    //edit
    public function edit($id)
    {
        $serviceAndMedicine = ServiceAndMedicine::findOrFail($id);
        return view('pages.service_and_medicine.edit', compact('serviceAndMedicine'));
    }

    //update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|integer',
            'quantity' => 'nullable|integer',
        ]);

        $serviceAndMedicine = ServiceAndMedicine::findOrFail($id);
        $serviceAndMedicine->name = $request->name;
        $serviceAndMedicine->category = $request->category;
        $serviceAndMedicine->price = $request->price;
        // Set quantity only if it's provided
        if ($request->has('quantity')) {
            $serviceAndMedicine->quantity = $request->quantity;
        }
        $serviceAndMedicine->save();

        return redirect()->route('services_and_medicines.index')
            ->with('success', 'Service and Medicine updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        $serviceAndMedicine = ServiceAndMedicine::findOrFail($id);
        $serviceAndMedicine->delete();

        return redirect()->route('services_and_medicines.index')->with('success', 'Service and Medicine deleted successfully.');
    }
}
