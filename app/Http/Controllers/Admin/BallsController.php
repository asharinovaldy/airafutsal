<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ball;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BallsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $balls = Ball::all();
        return view('admin.balls.index', compact('balls'));
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
        $request->validate([
            'image' => 'required|image|mimes:png,jpg',
            'balls_name' => 'required|string',
            'balls_price' => 'required|numeric',
            'balls_stock' => 'required|numeric',
        ]);

        $image = $request->file('image');
        $image->storeAs('public/images', $image->hashName());

        $balls = Ball::create([
            'image' => $image->hashName(),
            'name' => $request->balls_name,
            'price' => $request->balls_price,
            'stock' => $request->balls_stock,
        ]);

        if($balls){
            Alert::success('Success', 'Data Berhasil Disimpan!');
            return redirect()->route('admin.balls');
        }else{
            Alert::error('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin.balls');
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
        $balls = Ball::findOrFail($id);
        return view('admin.balls.edit', compact('balls'));
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
            'balls_name' => 'required|string',
            'balls_price' => 'required|numeric',
            'balls_stock' => 'required|numeric',
        ]);

        $ball = Ball::findOrFail($id);

        if ($request->file('image') == '') {
            $ball->update([
                'name' => $request->balls_name,
                'price' => $request->balls_price,
                'stock' => $request->balls_stock,
            ]);
        } else {
            // delete old image
            Storage::disk('local')->delete('public/images'.$ball->image);

            // upload new image
            $image = $request->file('image');
            $image->storeAs('public/images', $image->hashName());

            $ball->update([
                'image' => $image->hashName(),
                'name' => $request->balls_name,
                'price' => $request->balls_price,
                'stock' => $request->balls_stock,
            ]);
        }

        if($ball){
            Alert::success('Success', 'Data Berhasil Diubah!');
            return redirect()->route('admin.balls');
        }else{
            Alert::error('Error', 'Data Gagal Diubah!');
            return redirect()->route('admin.balls');
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
        $ball = Ball::findOrFail($id);
        Storage::disk('local')->delete('public/images'.$ball->image);
        $ball->delete();

        if($ball){
            Alert::success('Success', 'Data Berhasil Dihapus!');
            return redirect()->route('admin.balls');
        }else{
            Alert::error('Error', 'Data Gagal Dihapus!');
            return redirect()->route('admin.balls');
        }
    }
}
