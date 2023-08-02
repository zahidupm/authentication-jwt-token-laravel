<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::where('user_id', auth()->id());
        return view('customer.index', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|max:125|string',
                'email' => 'required|email',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable',
            ]);
            Customer::create([
               'name' => $request->name,
               'email' => $request->email,
               'address' => $request->address,
               'phone' => $request->phone,
                'user_id' => auth()->id(),
            ]);
            flash('Customer added successfully');
            return redirect()->route('customer.index');
        } catch (\Throwable $th) {
           return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::find($id);
        return view('customer.edit', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $customer = Customer::find($id);

            $request->validate([
                'name' => 'required|max:125|string',
                'email' => 'required|email',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable',
            ]);
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,
                'user_id' => auth()->id(),
            ]);
            flash('Customer updated successfully');
            return redirect()->route('customer.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        flash('Customer deleted successfully');
    }
}
