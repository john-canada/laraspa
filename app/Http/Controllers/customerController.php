<?php

namespace App\Http\Controllers;
use App\Customer;
use Illuminate\Http\Request;
use App\Http\Resources\customerResource;

class customerController extends Controller
{

    public function index()
    {
       $customer = Customer::orderBy('created_at','desc')->paginate(5); 
        return customerResource::collection($customer);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
       $customer = New Customer;
       $customer->name=$request->input('name');
       $customer->address=$request->input('address');
       $customer->email=$request->input('email');
       $customer->phone=$request->input('phone');
       if($customer->save()){
         return new customerResource($customer);
       }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->name=$request->input('name');
        $customer->address=$request->input('address');
        $customer->email=$request->input('email');
        $customer->phone=$request->input('phone');
        if($customer->update()){
            return new customerResource($customer);
        }
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        if($customer->delete()){
            return new customerResource($customer);
        }
    }
}
