<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Chapitre;
use App\Models\Formation;
use App\Models\Cours;
use App\Models\Classe;
use Illuminate\Http\Request;

class ChapitreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $chapitre = Chapitre::where('lecon','like',"%$keyword%")->paginate($perPage);
        } else {
            $chapitre = Chapitre::latest()->paginate($perPage);
        }

      
        return view('pages.chapitre.index', compact('chapitre'));
    }
public function getData($id=null){
   
    $cours=  Cours::all();
   
    $classe=Classe::all();
    return [$cours,$classe];
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
public function create()
    { 
         $data=$this->getData();
        list($cours,$classe)=$data;
        $co=Cours::all();
        return view('pages.chapitre.create',compact('co','cours','classe'));
    }
    public function createchapitre($id){
        $data=$this->getData();
        list($cours,$classe)=$data;
        $co=Cours::where('id',$id)->first();
        return view('pages.chapitre.create',compact('co','cours','classe'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        

        if($request->hasFile('document')){
            checkDirectory('enseignant');
            $requestData['document']=uploadFile($request,'document',public_path('uploads/enseignant'));
        }
         
        
        Chapitre::create($requestData);
     
        return redirect('admin/chapitre/create')->with('flash_message', 'Chapitre added!');
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
        $chapitre = Chapitre::findOrFail($id);

        return view('pages.chapitre.show', compact('chapitre'));
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
        $chapitre = Chapitre::findOrFail($id);
        $data=$this->getData($id);
        list($cours,$classe)=$data;
        return view('pages.chapitre.edit', compact('chapitre','cours','classe'));
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
        
        $requestData = $request->all();
        
        $chapitre = Chapitre::findOrFail($id);
        if($request->hasFile('document')){
            checkDirectory('enseignant');
            $requestData['document']=uploadFile($request,'document',public_path('uploads/enseignant'));
        }
        $chapitre->update($requestData);

        return redirect('admin/chapitre')->with('flash_message', 'Chapitre updated!');
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
        Chapitre::destroy($id);

        return redirect('admin/chapitre')->with('flash_message', 'Chapitre deleted!');
    }
}
