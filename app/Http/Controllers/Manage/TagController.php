<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Exception;

class TagController extends Controller {

    public function index () {

        $tags = Tag::all();
        return view('manage.tag.index', compact('tags'));
    }

    public function delete(Request $request) {

        Tag::where([
            'id' => $request->post('id')
        ])->delete();

        return redirect()->back()->with(['message' => ['Tag berhasil dihapus', 'warning']]);
    }

    public function add (Request $request) {

        try {

            $dt = $request->post('nama');
            $check = Tag::where('name', 'like', "%{$dt}%")->get();

            if (!$check->isEmpty()) {
                throw new Exception("Tag sudah ada");
            }

            Tag::create([
                'name' => $dt
            ]);

        } catch (Exception $e) {
            
            return redirect()->back()->with(['message' => [$e->getMessage(), 'danger']]);
        }

        return redirect()->back()->with(['message' => ['Tag berhasil ditambahkan', 'success']]);
    }

    public function update (Request $request) {

        Tag::where([
            'id' => $request->post('id')
        ])->update([
            'name' => $request->post('nama')
        ]);

        return redirect()->back()->with(['message' => ['Update berhasil', 'success']]);
    }
    
}
