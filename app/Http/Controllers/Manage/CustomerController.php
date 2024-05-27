<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller {

    public function index () {

        $customer = Customer::where([
            'is_admin' => 0
        ])->get();

        return view('manage.customer.index', compact('customer'));
    }

    public function update (Request $request) {

        Customer::where([
            'id' => $request->post('id')
        ])->update([
            'nama' => $request->post('nama')
        ]);

        return redirect()->back()->with(['message' => ['Update berhasil', 'success']]);
    }
}
