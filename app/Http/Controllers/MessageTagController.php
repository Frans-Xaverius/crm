<?php

namespace App\Http\Controllers;

use App\Models\QontakDatas;
use App\Models\Tag;
use App\Models\Eks;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class MessageTagController extends Controller
{
    //
    public function index(Request $request)
    {
        // $datas = QontakDatas::all()->map(function ($data) use ($request) {
        //     $tags = json_decode($data->tags);
        //     $rtags = json_decode($request->tags);
        //     // dd($data,$tags, $rtag);
        //     // if (in_array($tags, $rtag)) {
        //     //     return $data;
        //     // }
        //     foreach ($rtags as $rtag) {
        //         foreach ($tags as $tag) {
        //             if ($tag == $rtag) {
        //                 var_dump($rtag, $tag);
        //                 return $data;
        //             }
        //         }
        //     }
        // });
        // dd($datas);

        $data = Tag::orderBy('id', 'desc')->get();

        return view('tag.index', compact('data'));
    }

    public function tag()
    {

        $data = Tag::orderBy('name', 'asc')->pluck('name', 'id');

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function getTag(Request $request)
    {
        $data = QontakDatas::where('_id', $request->id)->first();
        $data->tags = json_decode($data->tags);
        $eks = Eks::where('r_id', $request->id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'eks' => !empty($eks) ? $eks->d_id : null
        ]);
    }

    public function assignTag(Request $request)
    {
        $data = QontakDatas::where('_id', $request->id)->first();
        if (!empty($request->tags)) {
            $data->tags = json_encode($request->tags);
        } else {
            $data->tags = null;
        }
        if (!empty($request->rating)) $data->rating = $request->rating;
        $data->save();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // public function removeTag(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         // $validated = $request->validate([
    //         //     '_id' => 'string|required',
    //         //     'tags' => 'array|required',
    //         //     'tags.*' => 'string|required'
    //         // ]);
    //         $data = QontakDatas::where('_id', $request->_id)->first();
    //         $rtags = json_decode($request->tags);
    //         $tags = json_decode($data->tags);
    //         $tags = array_filter($tags, function ($data) use ($rtags) {
    //             if (!in_array($data, $rtags)) {
    //                 // dd($data, $rtags);
    //                 return $data;
    //             }
    //         });
    //         $data->tags = json_encode(array_values($tags));
    //         $data->save();
    //         dd($data);
    //     } else {
    //         dd('fail');
    //     }
    //     // $tags = explode(',', $request->tags);
    //     // $tag = collect(explode(',',$data->tags))->filter(function ($data) use ($tags){
    //     //     if(!in_array($data, $tags)) {
    //     //         return $data;
    //     //     }
    //     // })->toArray();
    //     // $data->tags = implode(',',$tag);
    // }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => 'string|required'
            ]);
            $data = Tag::create($validated);

            return redirect()->route('tag.index');
        } else {
            return view('tag.add');
        }
    }

    public function edit(Request $request, $id)
    {
        $data = Tag::findorFail($id);
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => 'string|required'
            ]);

            $data->name = $validated['name'];
            $data->save();

            return redirect()->route('tag.index');
        } else {
            return view('tag.add', compact('data', 'id'));
        }
    }

    public function delete(Request $request, $id)
    {
        $data = Tag::findorFail($id)->delete();
        return redirect()->route('tag.index');
    }
}
