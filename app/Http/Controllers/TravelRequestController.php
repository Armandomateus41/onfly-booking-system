<?php

namespace App\Http\Controllers;

use App\Models\TravelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = TravelRequest::query()->where('user_id', Auth::id());

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has(['start_date', 'end_date'])) {
            $query->whereBetween('departure_date', [$request->start_date, $request->end_date]);
        }

        if ($request->has('destination')) {
            $query->where('destination', 'like', '%' . $request->destination . '%');
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'requester_name' => 'required|string',
            'destination' => 'required|string',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:departure_date',
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'solicitado';

        $request = TravelRequest::create($data);

        return response()->json($request, 201);
    }

    public function show($id)
    {
        $request = TravelRequest::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($request);
    }

    public function updateStatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|in:aprovado,cancelado',
        ]);

        $travel = TravelRequest::findOrFail($id);

        // Regra: apenas outro usuário pode alterar status
        if ($travel->user_id === Auth::id()) {
            return response()->json(['error' => 'Você não pode alterar o status do seu próprio pedido.'], 403);
        }

        $travel->status = $data['status'];
        $travel->save();

        return response()->json($travel);
    }

    public function cancel($id)
    {
        $travel = TravelRequest::where('user_id', Auth::id())->findOrFail($id);

        if ($travel->status !== 'aprovado') {
            return response()->json(['error' => 'Somente pedidos aprovados podem ser cancelados.'], 400);
        }

        $travel->status = 'cancelado';
        $travel->save();

        return response()->json(['message' => 'Pedido cancelado com sucesso.']);
    }
}