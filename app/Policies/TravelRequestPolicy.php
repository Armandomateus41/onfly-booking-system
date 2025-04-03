<?php

namespace App\Policies;

use App\Models\TravelRequest;
use App\Models\User;

class TravelRequestPolicy
{
    /**
     * Apenas usuários diferentes do criador podem alterar o status.
     */
    public function updateStatus(User $user, TravelRequest $request): bool
    {
        return $user->id !== $request->user_id;
    }

    /**
     * Apenas o criador pode cancelar, e apenas se estiver aprovado.
     */
    public function cancel(User $user, TravelRequest $request): bool
    {
        return $user->id === $request->user_id && $request->status === 'aprovado';
    }
}
