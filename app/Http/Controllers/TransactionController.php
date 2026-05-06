<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\TransactionType;
use App\Http\Requests\TransactionRequest;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Depot, Retrait,Transfert => Type de transaction Enumeration
     *
     *
     * case 'depot': montant, numero_compte_destinaire, numero_compte_emetteur, date (now), code (4 chiffres), status (en attente, validé, refusé),
     *
     * Frais de transaction : 1% du montant pour les dépôts et les retraits, 0.5% pour les transferts
     * 5000 FCFA minimum pour les dépôts et les retraits, 1000 FCFA minimum pour les transferts
     */
    public function index()
    {
        $user = auth()->user();
        $transactions = Transaction::where('sender_account_id', $user->id)
            ->orWhere('receiver_account_id', $user->id)
            ->get();
        return response()->json([
            'message' => 'Transactions retrieved successfully',
            'data' => $transactions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function transfert(TransactionRequest $request)
    {
        $validatedData = $request->validated();



        // Logique de traitement de la transaction
        // Vérifier les comptes, les montants, etc.

        $sender = Account::where('numero_compte', $validatedData['numero_compte_emetteur'])->first();
        $receiver = Account::where('numero_compte', $validatedData['numero_compte_destinaire'])->first();
        $fee = 0;
        $montantTotal = $validatedData['montant'];

        if ($validatedData['type'] === TransactionType::TRANSFERT) {
            $fee = $validatedData['montant'] * 0.01;
            $montantTotal = $validatedData['montant'] + $fee;
        }

        if ($sender->solde < $montantTotal) {
            return response()->json(
                [
                    'message' => 'Solde insuffisant, votre solde actuel est ' . $sender->solde
                ],
                400
            );
        }



        // Enregistrer la transaction dans la base de données
        $transaction = Transaction::create([
            'type' => $validatedData['type'],
            'montant' => $validatedData['montant'],
            'sender_account_id' => $sender->id,
            'receiver_account_id' => $receiver->id,
            'status' => Status::EN_ATTENTE,
            'code' => rand(1000, 9999), // Générer un code aléatoire à 4 chiffres
        ]);

        return response()->json([
            'message' => 'Transaction created successfully',
            'data' => $transaction
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
