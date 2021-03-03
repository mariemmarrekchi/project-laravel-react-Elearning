<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Categorie;
use Exception;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // $keyword = $request->get('search');
        // $perPage = 25;

        // if (!empty($keyword)) {
        //     $categorie = Categorie::latest()->paginate($perPage);
        // } else {
        //     $categorie = Categorie::latest()->paginate($perPage);
        // }
        $categorie = Categorie::all();
        return response()->json($categorie, 200);
        // return $categorie->toJson();
        // return view('pages.categorie.index', compact('categorie'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.categorie.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {   //check file
        // $requestData = $request->all();
        // if($request->hasFile('image')){
        //     checkDirectory('image');
        //     $requestData['image']=uploadFile($request,'image',public_path('img/image'));
        // }
        // $fileName="user_image.jpg";
        // $path=$request->file('image')->move(public_path("img/"),$fileName);
        // $photoUrl=url('/'.$fileName);
        // $image=$request->file('image');
        // $requestData['image']=time().'.'.$image->getClientOriginalExtension();
        // $destinataire=public_path('/img');
        // $image->move($destinataire,$input['image']);
        $requestData = $request->all();
        if($request->hasFile('image')){
            $image=$request->file('image')->getClientOriginalImage();
                $input=$image.'_'.time().'.'.$image->getClientOriginalExtension();
                $destinataire=public_path('/public/images/img/');
                $image->move($input);


        //   $request->file('image')->storage('public');   
            }
          
        Categorie::create($requestData);
        return response()->json($requestData, 200);
        //return  $requestData->toJson();
        //return redirect('admin/categorie')->with('flash_message', 'Categorie added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $categorie = Categorie::findOrFail($id);
        return  $categorie->toJson();
        //return view('pages.categorie.show', compact('categorie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);
        return  $categorie->toJson();
        //return view('pages.categorie.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        if($request->hasFile('image')){
            $image=$request->file('image')->getClientOriginalImage();
                $input=$image.'_'.time().'.'.$image->getClientOriginalExtension();
                $destinataire=public_path('/public/images/img/');
                $image->move($input);

            }
          
        $requestData = $request->all();
        
        $categorie = Categorie::findOrFail($id);
        $categorie->update($requestData);
        return response()->json($categorie, 200);
        // return response()->json(['data' => $categorie, 'message' => 'Updated successfully'], 200);
        //return redirect('admin/categorie')->with('flash_message', 'Categorie updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $categorie=Categorie::findOrFail($id);
       
        $categorie->delete();
       
            return response()->json($categorie,200);
    
        //Categorie::destroy($id);
          
    }  
}
