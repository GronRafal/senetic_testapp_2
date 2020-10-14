<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class VoyagerAddressController extends VoyagerBreadController
{
    public function browse(){
        $client = new Client([
            'auth' => [env("API_USER"), env("API_PASS")]
        ]);
        $response = $client->get('http://'.env("API_HOST").':'.env("API_PORT").'/api/customers');

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            return back()->with('danger','Login failed.');
        }else{
            $dataTypeContent = json_decode($response->getBody()->getContents());
            return view('customer.browse', ['dataTypeContent' => $dataTypeContent]);
        }
    }

    public function create(Request $request, $consumer = null){
        $request->validate([
            'city' => 'required|min:3|max:255',
            'street' => 'required|min:3|max:255'
        ]);
        $client = new Client([
            'auth' => [env("API_USER"), env("API_PASS")]
        ]);
        try {
            $response = $client->post('http://'.env("API_HOST").':'.env("API_PORT").'/api/customer/'.$request->customer.'/address',
                array(
                    'form_params' => array(
                        'city' => $request->city,
                        'street' => $request->street
                    )
                ));
        } catch (ClientException $e) {
            return redirect('admin/customer/'.$request->customer)->with(['message' => $e->getMessage(), 'alert-type' => 'error']);
        }
        return redirect('admin/customer/'.$request->customer )->with(['message' => "Succesfull added new address!", 'alert-type' => 'success']);
    }
    public function show($id){
        $client = new Client([
            'auth' => [env("API_USER"), env("API_PASS")]
        ]);
        $response = $client->get('http://'.env("API_HOST").':'.env("API_PORT").'/api/customer/'.$id);
        $dataTypeContent = json_decode($response->getBody()->getContents());
        foreach ($dataTypeContent as $customer) {
        }
        $response = $client->get('http://'.env("API_HOST").':'.env("API_PORT").'/api/customer/'.$id.'/addresses');
        $addresses = json_decode($response->getBody()->getContents());
        return view('customer.show', ['customer' => $customer, 'addresses' => $addresses]);
    }

    public function store($id){
        return view('address.edit-add', ['address' => null, 'customer' => $id]);
    }

    public function edit($id = null){
        $client = new Client([
            'auth' => [env("API_USER"), env("API_PASS")]
        ]);
        $response = $client->get('http://'.env("API_HOST").':'.env("API_PORT").'/api/address/'.$id);
        $dataTypeContent = json_decode($response->getBody()->getContents());
        foreach ($dataTypeContent as $address) {
        }
        return view('address.edit-add', ['address' => $address, 'customer' => $address->customer_id]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'city' => 'required|min:3|max:255',
            'street' => 'required|min:3|max:255'
        ]);
        $client = new Client([
            'auth' => [env("API_USER"), env("API_PASS")]
        ]);
        try {
            $response = $client->put('http://'.env("API_HOST").':'.env("API_PORT").'/api/address/'.$id,
                array(
                    'form_params' => array(
                        'city' => $request->city,
                        'street' => $request->street
                    )
                ));
        } catch (ClientException $e) {
            return redirect('admin/customer/'.$request->customer)->with(['message' => $e->getMessage(), 'alert-type' => 'error']);
        }
        return redirect('admin/customer/'.$request->customer )->with(['message' => "Succesfull edit the address!", 'alert-type' => 'success']);
    }

    public function destroy($id){
        $client = new Client([
            'auth' => [env("API_USER"), env("API_PASS")]
        ]);
        $response = $client->get('http://'.env("API_HOST").':'.env("API_PORT").'/api/address/'.$id);
        $dataTypeContent = json_decode($response->getBody()->getContents());
        foreach ($dataTypeContent as $address) {
        }
        $response = $client->delete('http://'.env("API_HOST").':'.env("API_PORT").'/api/address/'.$id);
        return redirect('admin/customer/'.$address->customer_id )->with(['message' => "Succesfull edit the address!", 'alert-type' => 'success']);
    }
}
