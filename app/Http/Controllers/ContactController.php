<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of contacts
     */
    public function index(Request $request)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $query = Contact::where('store_id', $store->id);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } else {
                $query->where('is_active', false);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $contacts = $query->orderBy('name')->paginate(20)->withQueryString();

        // Summary
        $summary = [
            'total_suppliers' => Contact::where('store_id', $store->id)->where('type', 'supplier')->count(),
            'total_customers' => Contact::where('store_id', $store->id)->where('type', 'customer')->count(),
        ];

        return view('contacts.index', compact('contacts', 'store', 'summary'));
    }

    /**
     * Show the form for creating a new contact
     */
    public function create(Request $request)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $type = $request->get('type', 'customer');

        return view('contacts.create', compact('store', 'type'));
    }

    /**
     * Store a newly created contact
     */
    public function store(Request $request)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:supplier,customer',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['store_id'] = $store->id;
        $validated['is_active'] = true;

        Contact::create($validated);

        $typeLabel = $validated['type'] === 'supplier' ? 'Supplier' : 'Pelanggan';

        return redirect()->route('contacts.index', ['type' => $validated['type']])
            ->with('success', "{$typeLabel} berhasil ditambahkan!");
    }

    /**
     * Display the specified contact
     */
    public function show(Contact $contact)
    {
        $this->authorizeContact($contact);

        $contact->load(['debts' => function ($query) {
            $query->orderByDesc('debt_date')->limit(10);
        }]);

        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing a contact
     */
    public function edit(Contact $contact)
    {
        $this->authorizeContact($contact);

        $store = Auth::user()->currentStore();

        return view('contacts.edit', compact('contact', 'store'));
    }

    /**
     * Update the specified contact
     */
    public function update(Request $request, Contact $contact)
    {
        $this->authorizeContact($contact);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:supplier,customer',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $contact->update($validated);

        return redirect()->route('contacts.index', ['type' => $contact->type])
            ->with('success', 'Kontak berhasil diperbarui!');
    }

    /**
     * Remove the specified contact
     */
    public function destroy(Contact $contact)
    {
        $this->authorizeContact($contact);

        // Check if contact has debts
        if ($contact->debts()->exists()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus kontak yang memiliki hutang/piutang!');
        }

        $type = $contact->type;
        $contact->delete();

        return redirect()->route('contacts.index', ['type' => $type])
            ->with('success', 'Kontak berhasil dihapus!');
    }

    /**
     * Check if user has access to contact's store
     */
    private function authorizeContact(Contact $contact)
    {
        $store = Auth::user()->currentStore();

        if (!$store || $contact->store_id !== $store->id) {
            abort(403, 'Anda tidak memiliki akses ke kontak ini.');
        }
    }
}
