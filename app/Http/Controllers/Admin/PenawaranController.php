<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use App\Models\Client;
use App\Models\User;
use App\Models\Decking;
use App\Models\Ceiling;
use App\Models\Wallpanel;
use App\Models\Flooring;
use App\Models\Facade;
use Illuminate\Http\Request;
use App\Http\Requests\StorePenawaranRequest;

class PenawaranController extends Controller
{
    public function index()
    {
        $penawarans = Penawaran::with(['client', 'user'])->latest()->paginate(10);
        return view('admin.penawaran.index', compact('penawarans'));
    }

    public function create()
    {
        $clients = Client::active()->notDeleted()->get();
        $users = User::all();
        $deckings = Decking::active()->get();
        $ceilings = Ceiling::active()->get();
        $wallpanels = Wallpanel::active()->get();
        $floorings = Flooring::active()->get();
        $facades = Facade::active()->get();
        return view('admin.penawaran.create', compact('clients', 'users', 'deckings', 'ceilings', 'wallpanels', 'floorings', 'facades'));
    }

    public function store(StorePenawaranRequest $request)
    {
        $data = $request->validated();
        $data['id_user'] = auth()->id();
        Penawaran::create($data);
        return redirect()->route('admin.penawaran.index')->with('success', 'Penawaran berhasil dibuat.');
    }

    public function show(Penawaran $penawaran)
    {
        return view('admin.penawaran.show', compact('penawaran'));
    }

    public function edit(Penawaran $penawaran)
    {
        $clients = Client::active()->notDeleted()->get();
        $users = User::all();
        $deckings = Decking::active()->get();
        $ceilings = Ceiling::active()->get();
        $wallpanels = Wallpanel::active()->get();
        $floorings = Flooring::active()->get();
        $facades = Facade::active()->get();
        return view('admin.penawaran.edit', compact('penawaran', 'clients', 'users', 'deckings', 'ceilings', 'wallpanels', 'floorings', 'facades'));
    }

    public function update(StorePenawaranRequest $request, Penawaran $penawaran)
    {
        $data = $request->validated();
        $penawaran->update($data);
        return redirect()->route('admin.penawaran.index')->with('success', 'Penawaran berhasil diupdate.');
    }

    public function destroy(Penawaran $penawaran)
    {
        $penawaran->delete();
        return redirect()->route('admin.penawaran.index')->with('success', 'Penawaran berhasil dihapus.');
    }
}
