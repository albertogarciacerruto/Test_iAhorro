<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Expert;

class ClientController extends Controller
{
    public function list_clients() 
    {
		$list_clients = Client::get();
		return response()->json([
				'clients' => $list_clients,
		], 200);
	}

	public function register_client(Request $request)
	{
        $expert = Expert::inRandomOrder()->select('id')->first();

        $client = new Client;
        $client->name = $request->name;
        $client->lastname = $request->lastname;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->neto = $request->neto;
        $client->quantity = $request->quantity;
        $client->timeStart = $request->timeStart;
        $client->timeEnd = $request->timeEnd;
        $client->idExpert = $expert->id;
        $client->save();

        $newClient = Client::Where('id', '=', $client->id)->first();

        return response()->json([
            'message' => 'Cliente creado con exito.',
            'client' => $newClient ], 201);
    }
    
}
