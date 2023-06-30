<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BootsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $boots = Boots::all();
        return view('admin.boots.index', compact('boots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $request->validate([
            'image' => 'required|image|mimes:png,jpg',
            'boots_name' => 'required|string',
            'boots_size' => 'required|numeric',
            'boots_price' => 'required|numeric',
            'boots_stock' => 'required|numeric',
        ]);

        $image = $request->file('image');
        $image->storeAs('public/images', $image->hashName());

        $boots = Boots::create([
            'image' => $image->hashName(),
            'name' => $request->boots_name,
            'size' => $request->boots_size,
            'price' => $request->boots_price,
            'stock' => $request->boots_stock,
        ]);

        if($boots){
            Alert::success('Success', 'Data Berhasil Disimpan!');
            return redirect()->route('admin.boots');
        }else{
            Alert::error('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin.boots');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $boots = Boots::findOrFail($id);
        return view('admin.boots.edit', compact('boots'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'image' => 'image|mimes:png,jpg',
            'boots_name' => 'required|string',
            'boots_size' => 'required|numeric',
            'boots_price' => 'required|numeric',
            'boots_stock' => 'required|numeric',
        ]);

        $boot = Boots::findOrFail($id);

        if ($request->file('image') == '') {
            $boot->update([
                'name' => $request->boots_name,
                'size' => $request->boots_size,
                'price' => $request->boots_price,
                'stock' => $request->boots_stock,
            ]);
        } else {
            // delete old image
            Storage::disk('local')->delete('public/images'.$boot->image);

            // upload new image
            $image = $request->file('image');
            $image->storeAs('public/images', $image->hashName());

            $boot->update([
                'image' => $image->hashName(),
                'name' => $request->boots_name,
                'size' => $request->boots_size,
                'price' => $request->boots_price,
                'stock' => $request->boots_stock,
            ]);
        }

        if($boot){
            Alert::success('Success', 'Data Berhasil Diubah!');
            return redirect()->route('admin.boots');
        }else{
            Alert::error('Error', 'Data Gagal Diubah!');
            return redirect()->route('admin.boots');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $boot = Boots::findOrFail($id);
        Storage::disk('local')->delete('public/images'.$boot->image);
        $boot->delete();

        if($boot){
            Alert::success('Success', 'Data Berhasil Dihapus!');
            return redirect()->route('admin.boots');
        }else{
            Alert::error('Error', 'Data Gagal Dihapus!');
            return redirect()->route('admin.boots');
        }
    }
}
