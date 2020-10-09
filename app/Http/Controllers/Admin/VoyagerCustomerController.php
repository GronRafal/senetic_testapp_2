<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class VoyagerCustomerController extends VoyagerBreadController
{
    public function browse(){
        $username = env("API_USER");
        $password = env("API_PASS");

        $client = new Client();
        $response = $client->get('http://127.0.0.1:9201/api/customers', [
            'auth' => [$username, $password]
        ]);

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            return back()->with('danger','Login failed.');
        }else{
            $dataTypeContent = json_decode($response->getBody()->getContents());
            return view('customer.browse', ['dataTypeContent' => $dataTypeContent]);
        }
    }

    public function create(Request $request, $consumer = null){
        $username = env("API_USER");
        $password = env("API_PASS");
        $client = new Client([
            'auth' => [$username, $password]
        ]);
        $response = $client->post('http://127.0.0.1:9201/api/customer/',
            array(
                'form_params' => array(
                    'name' => $request->name
                )
            ));
        return redirect('admin/customer')->with(['message' => "Succesfull added new customer!", 'alert-type' => 'success']);
    }
    public function show($id){
        $username = env("API_USER");
        $password = env("API_PASS");

        $client = new Client();
        $response = $client->get('http://127.0.0.1:9201/api/customer/'.$id, [
            'auth' => [$username, $password]
        ]);
        $dataTypeContent = json_decode($response->getBody()->getContents());
        foreach ($dataTypeContent as $customer) {
        }
        $response = $client->get('http://127.0.0.1:9201/api/customer/'.$id.'/addresses', [
            'auth' => [$username, $password]
        ]);
        $addresses = json_decode($response->getBody()->getContents());
        return view('customer.show', ['customer' => $customer, 'addresses' => $addresses]);
    }

    public function store(Request $request){
        return view('customer.edit-add', ['customer' => null]);
    }

    public function edit($customer = null){
        $username = env("API_USER");
        $password = env("API_PASS");

        $client = new Client();
        $response = $client->get('http://127.0.0.1:9201/api/customer/'.$customer, [
            'auth' => [$username, $password]
        ]);
        $dataTypeContent = json_decode($response->getBody()->getContents());
        foreach ($dataTypeContent as $customer) {
        }
        return view('customer.edit-add', ['customer' => $customer]);
    }

    public function update(Request $request, $id){
        $username = env("API_USER");
        $password = env("API_PASS");

        $client = new Client([
            'auth' => [$username, $password]
        ]);
        $response = $client->put('http://127.0.0.1:9201/api/customer/'.$id,
            array(
                'form_params' => array(
                    'name' => $request->name
                )
            ));
        return redirect('admin/customer')->with(['message' => "Succesfull edit the customer!", 'alert-type' => 'success']);
    }

    public function destroy($id){
        $username = env("API_USER");
        $password = env("API_PASS");

        $client = new Client();
        $response = $client->delete('http://127.0.0.1:9201/api/customer/'.$id, [
            'auth' => [$username, $password]
        ]);
        return redirect('admin/customer')->with(['message' => "Succesfull remove the customer!", 'alert-type' => 'success']);
    }
}
