<?php

// app/Http/Controllers/BaserowCrudController.php
namespace App\Http\Controllers;

use App\Services\BaserowService;
use Illuminate\Http\Request;

class BaserowCrudController extends Controller
{
    protected $baserow;

    public function __construct(BaserowService $baserow)
    {
        $this->baserow = $baserow;
    }

    public function index(string $table)
    {
        $rows = $this->baserow->fetch($table);
        return view('crud.index', compact('rows', 'table'));
    }

    public function create(string $table)
    {
       
        $rows   = $this->baserow->fetch($table);
        $fields = ['Name','Title','Description'];
        return view('crud.form', compact('table','fields')); 
    }

    public function store(Request $request, string $table)
    {
        $data = $request->only(['Name','Title','Description']);
        $this->baserow->create($table, $data);
        return redirect()->route('crud.index', $table);
    }

    public function edit(string $table, int $id)
    {
        $rows   = $this->baserow->fetch($table);
        $row    = collect($rows)->firstWhere('id', $id);
        $fields = ['Name','Title','Description'];
        return view('crud.form', compact('table','row','fields'));

    }

    public function update(Request $request, string $table, int $id)
    {
        $data = $request->only(['Name','Title','Description']); 
        $this->baserow->update($table, $id, $data);
        return redirect()->route('crud.index', $table);
    }

    public function destroy(string $table, int $id)
    {
        $this->baserow->delete($table, $id);
        return redirect()->route('crud.index', $table);
    }
    
}
