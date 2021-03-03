<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\etudiant;
use App\Models\Nationality;
use App\Models\Classe;
use Illuminate\Http\Request;

class EtudiantController extends Controller
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
            $etudiant = etudiant::where('matricule', 'like', "%$keyword%")->paginate($perPage);
        } else {
            $etudiant = etudiant::latest()->paginate($perPage);
        }

        return view('pages.etudiant.index', compact('etudiant'));
    }
    function getFormData($id=null)
    {
        $nationality=Nationality::all();
        $class=Classe::all();
        $user=User::all();
        return [$user,$class,$nationality];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {$user=User::all();
        $class=Classe::all();
        $data=$this->getFormData();
        list($user,$class,$nationality) = $data;
        return view('pages.etudiant.create',compact('user','class','nationality'));
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
        if($request->hasFile('photo')){
            checkDirectory("etudiant");
            $requestData["photo"]=uploadFile($request,'photo',public_path('uploads/etudiant'));
        }
        
      etudiant::create($requestData);

        return redirect('admin/etudiant')->with('flash_message', 'etudiant added!');
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
        $etudiant =etudiant::findOrFail($id);

        return view('pages.etudiant.show', compact('etudiant'));
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
        $etudiant = etudiant::findOrFail($id);
        $data=$this->getFormData($id);
        list($user,$class,$nationality) = $data;
        return view('pages.etudiant.edit', compact('etudiant','user','class','nationality'));
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
        
        $etudiant = etudiant::findOrFail($id);
        if($request->hasFile('photo')){
            checkDirectory("etudiant/");
            $requestData["photo"]=uploadFile($request,'photo',public_path('uploads/etudiant'));
        }
        $etudiant->update($requestData);

        return redirect('admin/etudiant')->with('flash_message', 'etudiant updated!');
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
       etudiant::destroy($id);

        return redirect('admin/etudiant')->with('flash_message', 'etudiant deleted!');
    }
}
