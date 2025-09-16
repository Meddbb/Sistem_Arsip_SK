<?php

namespace App\Policies;

use App\Models\SK;
use App\Models\User;

class SKPolicy
{
    public function viewAny(?User $user): bool
    {
        return true; // Semua orang bisa melihat daftar SK
    }

    public function view(?User $user, SK $sk): bool
    {
        return true; // Semua orang bisa melihat detail SK
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isAnggotaDivisi();
    }

    public function update(User $user, SK $sk): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isAnggotaDivisi()) {
            return $sk->division_id === $user->division_id;
        }

        return false;
    }

    public function delete(User $user, SK $sk): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isAnggotaDivisi()) {
            return $sk->division_id === $user->division_id;
        }

        return false;
    }
}