<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FactureClient;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\image;
use App\Models\User;





class ClientController extends Controller
{
    public function index()
    {
        $this->authorize('update', Patient::class);
        $clients = Client::with('user')->latest()->paginate(50);
        return view('admin.clients.index', compact('clients'));

    }

    public function create(User $user)
    {
        $this->authorize('update', Patient::class);
        $users = User::where('role_id', '=', 2)->with('patients')->get();
        return view('admin.clients.create',compact('users'));
    }

    public function store(Request $request)
    {
        $this->authorize('update', Patient::class);

            $request->validate([
                'nom'=> 'required',
                'prenom'=> '',
                'motif'=> '',
                'montant'=> '',
                'avance'=> '',
                'reste'=> '',
                'partassurance'=> '',
                'partpatient'=> '',
                'assurance'=> '',
                 'numero_assurance'=> '',
                  'prise_en_charge'=> '',
                  'demarcheur'=> '',
                  'medecin_r'=>  '',
                  'date_insertion'=>  '',

               
               
            ]);
            $client = new Client();
            $client->nom = $request->get('nom');
            $client->prenom = $request->get('prenom');
        $client->montant = $request->get('montant');
        $client->assurance = $request->get('assurance');
        $client->avance = $request->get('avance');
        $client->date_insertion = $request->get('date_insertion');

        $client->numero_assurance = $request->get('numero_assurance');
        $client->prise_en_charge = $request->get('prise_en_charge');

        $client->partassurance = ((int)$request->get('montant')) - ((int)$client->partpatient);
        $client->partpatient = ((int)$request->get('montant') * (((int)$request->get('prise_en_charge')) / 100));
        if ($client->assurance){
            if ($client->avance){
                $client->reste = ($client->partpatient - $client->avance);
                $client->avance = $client->avance;
                $client->partassurance = ((int)$request->get('montant')) - ((int)$client->partpatient);
            }else{
                $client->reste = 0;
                $client->avance = $client->partpatient;
                $client->partassurance = ((int)$request->get('montant') * (((int)$request->get('prise_en_charge')) / 100));
                $client->partpatient = ((int)$request->get('montant')) - ((int)$client->partpatient);
            }
        }else{
            if ($client->avance){
                $client->reste = ((int)$request->get('montant') - (int)$request->get('avance'));
                $client->partpatient = 0;
                $client->partassurance = 0;
            }else{
                $client->reste = 0;
                $client->avance = $request->get('montant');
                $client->partassurance = 0;
                $client->partpatient = 0;
            }
        }
        
         $client->assurance = $request->get('assurance');

            $client->motif = $request->get('motif');
            $client->medecin_r = $request->get('medecin_r');
            $client->user_id = Auth::id();
            $client->save();

        return redirect()->route('clients.index')->with('success', 'Le client a été ajouté avec succès !');
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', Patient::class);
        $request->validate([
            'nom'=> '',
            'prenom'=> '',
            'assurance'=> '',
            'partpatient'=> '',
            'partassurance'=> '',
            'numero_assurance'=> '',
            'montant'=> '',
            'motif'=> '',
            'avance'=> '',
            'reste'=> '',
            'demarcheur'=> '',
            'prise_en_charge'=> '',
            'medecin_r' => 'medecin_r',
            'date_insertion' => 'date_insertion',
          
        ]);


        $client = Client::findOrFail($id);
       
        $client->assurance = $request->get('assurance');
        $client->numero_assurance = $request->get('numero_assurance');
        $client->name = $request->get('nom');
        $client->montant = $request->get('montant');
        $client->avance = $request->get('avance');
        $client->reste = $request->get('reste');
        $client->partpatient = $request->get('partpatient');
        $client->partassurance = $request->get('partassurance');
        $client->demarcheur = $request->get('demarcheur');
        $client->prise_en_charge = $request->get('prise_en_charge');
        $client->motif = $request->get('motif');
        $client->prenom = $request->get('prenom');
        $client->medecin_r = $request->get('medecin_r');
        $client->date_insertion = $request->get('date_insertion');
        $client->user_id = Auth::id();
        $client->save();

        return redirect()->route('clients.index', $client->id)->with('success', 'Les informations ont été mis à jour avec succès !');
    }
    
    public function destroy(Client $client)
    {
        $this->authorize('update', Patient::class);
        $client->delete();

        return redirect()->route('clients.index')->with('success', "Le client a bien été supprimé");
    }


    public function generate_client(Request $request, $id)
    {
        $this->authorize('update', Patient::class);
        $client = Client::find($id);

        FactureClient::create([
            
            'client_id' => $client->id,
            'assurance' => $client->assurance,
            'partassurance' => $client->partassurance,
            'partpatient' => $client->partpatient,
            'motif' => $client->motif,
            'montant' => $client->montant,
            'demarcheur' => $client->demarcheur,
            'avance' => $client->avance,
            'reste' => $client->reste,
            'prenom' => $client->prenom,
            'nom' => $client->nom,
            'medecin_r' => $client->medecin_r,
            'date_insertion' => $client->date_insertion,
            'user_id' => \auth()->id(),
        ]);


        return redirect()->route('factures.client')->with('success', 'La facture a bien été généré veuillez consulter votre liste des factures');
    }


    
}






















