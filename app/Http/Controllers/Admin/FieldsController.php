<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fields;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FieldsController extends Controller
{
    //
    public function index(){
        $fields = Fields::all();
        return view('admin.fields.index', compact('fields'));
    }

    public function data()
    {
        $fields = Fields::all();
        return datatables()::of($fields)
            ->addIndexColumn()
            ->editColumn('action', function ($fields) {
                return '<form action="' . route('admin.delete.fields', $fields->id) . '" method="POST">
                    <a href="' . route('admin.edit.fields', [$fields->id]) . '" class="btn btn-primary" title="Detail">Edit</a>
                    ' . csrf_field() . '
                    ' . method_field("DELETE") . '
                    <button title="Delete" type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure?\')"> Delete </button>
                </form>';
            })
            ->make(true);
    }

    public function store(Request $request){
        $request->validate([
            'field_name' => 'required|string',
            'price' => 'required|numeric'
        ]);

        Fields::create([
            'field_name' => $request->field_name,
            'price' => $request->price,
        ]);

        Alert::success('Success', 'Data berhasil disimpan');
        return redirect()->route('admin.fields');
    }

    public function edit($id){
        $field = Fields::where('id', $id)->first();

        return view('admin.fields.edit', compact('field'));
    }

    public function update(Request $request, $id){

        $field = Fields::where('id', $id)->first();

        $request->validate([
            'field_name' => 'required|string',
            'price' => 'required|numeric'
        ]);

        $field->update([
            'field_name' => $request->field_name,
            'price' => $request->price,
        ]);

        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.fields');
    }

    public function destroy($id){
        $field = Fields::findOrFail($id);
        $field->delete();

        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('admin.fields');
    }
}
