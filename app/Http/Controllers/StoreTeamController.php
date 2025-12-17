<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreTeamController extends Controller
{
    /**
     * Display team members for a store
     */
    public function index(Store $store)
    {
        $this->authorizeOwner($store);

        $members = $store->users()
            ->orderByRaw("FIELD(store_user.role, 'owner', 'manager', 'kasir')")
            ->orderBy('name')
            ->get();

        return view('stores.team.index', compact('store', 'members'));
    }

    /**
     * Show form to invite a new team member
     */
    public function create(Store $store)
    {
        $this->authorizeOwner($store);

        return view('stores.team.invite', compact('store'));
    }

    /**
     * Invite a new team member
     */
    public function invite(Request $request, Store $store)
    {
        $this->authorizeOwner($store);

        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|in:manager,kasir',
        ]);

        $user = User::where('email', $validated['email'])->first();

        // Check if user is already a member
        if ($store->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'User ini sudah menjadi anggota toko!');
        }

        // Add user to store
        $store->users()->attach($user->id, [
            'role' => $validated['role'],
        ]);

        $roleLabel = $validated['role'] === 'manager' ? 'Manager' : 'Kasir';

        return redirect()->route('stores.team.index', $store)
            ->with('success', "{$user->name} berhasil ditambahkan sebagai {$roleLabel}!");
    }

    /**
     * Update a team member's role
     */
    public function updateRole(Request $request, Store $store, User $user)
    {
        $this->authorizeOwner($store);

        // Cannot change owner's role
        if ($store->getUserRole($user) === 'owner') {
            return redirect()->back()
                ->with('error', 'Tidak dapat mengubah role pemilik toko!');
        }

        $validated = $request->validate([
            'role' => 'required|in:manager,kasir',
        ]);

        $store->users()->updateExistingPivot($user->id, [
            'role' => $validated['role'],
        ]);

        $roleLabel = $validated['role'] === 'manager' ? 'Manager' : 'Kasir';

        return redirect()->route('stores.team.index', $store)
            ->with('success', "Role {$user->name} berhasil diubah menjadi {$roleLabel}!");
    }

    /**
     * Remove a team member
     */
    public function remove(Store $store, User $user)
    {
        $this->authorizeOwner($store);

        // Cannot remove owner
        if ($store->getUserRole($user) === 'owner') {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus pemilik toko!');
        }

        // Cannot remove self
        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus diri sendiri dari toko!');
        }

        $store->users()->detach($user->id);

        return redirect()->route('stores.team.index', $store)
            ->with('success', "{$user->name} berhasil dihapus dari toko!");
    }

    /**
     * Transfer ownership to another user
     */
    public function transferOwnership(Request $request, Store $store)
    {
        $this->authorizeOwner($store);

        $validated = $request->validate([
            'new_owner_id' => 'required|exists:users,id',
        ]);

        $newOwner = User::findOrFail($validated['new_owner_id']);

        // Check if new owner is already a member
        if (!$store->users()->where('user_id', $newOwner->id)->exists()) {
            return redirect()->back()
                ->with('error', 'User harus menjadi anggota toko terlebih dahulu!');
        }

        DB::transaction(function () use ($store, $newOwner) {
            // Change current owner to manager
            $store->users()->updateExistingPivot(Auth::id(), [
                'role' => 'manager',
            ]);

            // Make new owner
            $store->users()->updateExistingPivot($newOwner->id, [
                'role' => 'owner',
            ]);
        });

        return redirect()->route('stores.team.index', $store)
            ->with('success', "Kepemilikan toko berhasil dipindahkan ke {$newOwner->name}!");
    }

    /**
     * Leave a store (for non-owners)
     */
    public function leave(Store $store)
    {
        $user = Auth::user();

        // Cannot leave if owner
        if ($store->getUserRole($user) === 'owner') {
            return redirect()->back()
                ->with('error', 'Pemilik toko tidak dapat keluar. Pindahkan kepemilikan terlebih dahulu.');
        }

        $store->users()->detach($user->id);

        // Clear current store from session if it was the active one
        if (session('current_store_id') == $store->id) {
            session()->forget('current_store_id');
        }

        return redirect()->route('dashboard')
            ->with('success', "Anda telah keluar dari toko {$store->name}.");
    }

    /**
     * Check if current user is owner of the store
     */
    private function authorizeOwner(Store $store)
    {
        if (!Auth::user()->isOwnerOf($store)) {
            abort(403, 'Hanya pemilik toko yang dapat mengelola tim.');
        }
    }
}
