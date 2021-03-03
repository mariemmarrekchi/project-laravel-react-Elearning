<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Nationality;
use App\Models\Enseignant;
use Corcel\Model\Post;
use Corcel\Model\User;
use Illuminate\Http\Request;
use App\Models\posteEnseignant;

class EnseignantController extends Controller
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
            $enseignant = Enseignant::Where('nom','like',"%$keyword%")->paginate($perPage);
        } else {
            $enseignant = Enseignant::latest()->paginate($perPage);
        }

        return view('pages.enseignant.index', compact('enseignant'));
    }
    function getFormData($id=null)
    {
        $nationality=Nationality::all();
        $poste=posteEnseignant::all();
        return [$nationality,$poste];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    { $data=$this->getFormData();
        list($nationality,$poste) = $data;
        return view('pages.enseignant.create',compact('nationality','poste'));
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
            checkDirectory('enseignant');
            $requestData['photo']=uploadFile($request,'photo',public_path('uploads/enseignant'));
        }

        if($request->hasFile('desc')){
            checkDirectory('enseignant');
            $requestData['desc']=uploadFile($request,'desc',public_path('uploads/enseignant'));
        }

        Enseignant::create($requestData);

        return redirect('admin/enseignant')->with('flash_message', 'Enseignant added!');
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
        $enseignant = Enseignant::findOrFail($id);

        return view('pages.enseignant.show', compact('enseignant'));
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
        $enseignant = Enseignant::findOrFail($id);
        $data=$this->getFormData($id);
        list($nationality,$poste) = $data;

        return view('pages.enseignant.edit', compact('enseignant','nationality','poste'));
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
        
        $enseignant = Enseignant::findOrFail($id);
        if($request->hasFile('photo')){
            checkDirectory('enseignant');
            $requestData['photo']=uploadFile($request,'photo',public_path('uploads/enseignant'));
        }
        if($request->hasFile('desc')){
            checkDirectory('enseignant');
            $requestData['desc']=uploadFile($request,'desc',public_path('uploads/enseignant'));
        }
        $enseignant->update($requestData);

        return redirect('admin/enseignant')->with('flash_message', 'Enseignant updated!');
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
        Enseignant::destroy($id);

        return redirect('admin/enseignant')->with('flash_message', 'Enseignant deleted!');
    }
}
