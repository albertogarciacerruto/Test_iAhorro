<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Expert;

class ExpertController extends Controller
{
    public function list_experts() 
    {
		$list_experts = Expert::get();
		return response()->json([
				'experts' => $list_experts,
		], 200);
    }
    
    public function get_expert($idExpert)
    {
      try {
        $client = Client::where('idExpert', '=', $idExpert)->get();
        $expert = Expert::where('id', '=', $idExpert)->first();
        $count = count($client);
        for ($i = 0; $i < $count; $i++) {
            $element = Client::where('id', '=', $client[$i]->id)->first();
            //Obtengo fecha actual
            $dateNow = new \DateTime();
            $dateNow->format('d-m-Y H:i:s');

            //obtengo fecha del registro
            $dateRegister = $element->created_at;

            //Se calcula la diferencia
            $time = $dateNow->diff($dateRegister);
            //Obtengo Neto y Cantidad Solicitada
            $neto = $element->neto;
            $quantity = $element->quantity;
            
            //Calculo Scoring
            $scoring = ($quantity/$neto)*$time->f;
            $update = Client::where('id', $element->id)->update(['order' => $scoring]);     
        }
        $client = Client::where('idExpert', '=', $idExpert)->select('name', 'lastname', 'email', 'phone', 'timeStart', 'timeEnd')->orderBy('order')->get();;

        return response()->json([
        'expert' => $expert,
        'client' => $client,
        ], 200);
      }
      catch(\Illuminate\Database\QueryException $ex) {
        return response()->json([
            'message' => "Experto no registrado.",
            ], 200);
      }
    }

}
