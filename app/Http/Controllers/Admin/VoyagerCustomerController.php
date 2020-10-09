<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class VoyagerCustomerController extends VoyagerBreadController
{
    public function browse(){
        $client = new Client([
            'auth' => [env("API_USER"), env("API_PASS")]
        ]);
        $response = $client->get('http://127.0.0.1:9201/api/customers');

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            return back()->with('danger','Login failed.');
        }else{
            $dataTypeContent = json_decode($response->getBody()->getContents());
            return view('customer.browse', ['dataTypeContent' => $dataTypeContent]);
        }
    }

    public function create(Request $request, $consumer = null){
        $request->validate([
            'name' => 'required|min:3|max:255'
        ]);
        $client = new Client([
            'auth' => [env("API_USER"), env("API_PASS")]
        ]);
        try {
            $response = $client->post('http://127.0.0.1:9201/api/customer/',
                array(
                    'form_params' => array(
                        'name' => $request->name
                    )
                ));
        } catch (ClientException $e) {
            return redirect('admin/customer')->with(['message' => $e->getMessage(), 'alert-type' => 'error']);
        }
        return redirect('admin/customer')->with(['message' => "Succesfull added new customer!", 'alert-type' => 'success']);
    }
    public function show($id){
        $client = new Client([
            'auth' => [env("API_USER"), env("API_PASS")]
        ]);
        $response = $client->get('http://127.0.0.1:9201/api/customer/'.$id);
        $dataTypeContent = json_decode($response->getBody()->getContents());
        foreach ($dataTypeContent as $customer) {
        }
        $response = $client->get('http://127.0.0.1:9201/api/customer/'.$id.'/addresses');
        $addresses = json_decode($response->getBody()->getContents());
        return view('customer.show', ['customer' => $customer, 'addresses' => $addresses]);
    }

    public function store(Request $request){
        return view('customer.edit-add', ['customer' => null]);
    }

    public function edit($customer = null){
        if (!is_null($customer)) {
            $client = new Client([
                'auth' => [env("API_USER"), env("API_PASS")]
            ]);
            $response = $client->get('http://127.0.0.1:9201/api/customer/'.$customer);
            $dataTypeContent = json_decode($response->getBody()->getContents());
            foreach ($dataTypeContent as $customer) {
            }
        }
        return view('customer.edit-add', ['customer' => $customer]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|min:3|max:255'
        ]);
        $username = env("API_USER");
        $password = env("API_PASS");

        $client = new Client([
            'auth' => [env("API_USER"), env("API_PASS")]
        ]);
        try {
            $response = $client->put('http://127.0.0.1:9201/api/customer/'.$id,
                array(
                    'form_params' => array(
                        'name' => $request->name
                    )
                ));
        } catch (ClientException $e) {
            return redirect('admin/customer')->with(['message' => $e->getMessage(), 'alert-type' => 'error']);
        }
        return redirect('admin/customer')->with(['message' => "Succesfull edit the customer!", 'alert-type' => 'success']);
    }

    public function destroy($id){
        $client = new Client([
            'auth' => [env("API_USER"), env("API_PASS")]
        ]);
        $response = $client->delete('http://127.0.0.1:9201/api/customer/'.$id);
        return redirect('admin/customer')->with(['message' => "Succesfull remove the customer!", 'alert-type' => 'success']);
    }
}
