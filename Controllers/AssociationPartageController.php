<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\AssociationPartage;
use App\Models\Enseignant;
use App\Models\Formation;
use App\Models\Cours;
use Illuminate\Http\Request;

class AssociationPartageController extends Controller
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
            $association = AssociationPartage::latest()->paginate($perPage);
        } else {
            $association = AssociationPartage::latest()->paginate($perPage);
        }

        return view('pages.association.index', compact('association'));
    }
    public function getData($id=null){
        $enseignant=Enseignant::all();
        $cours=Cours::all();
        $formation=Formation::all();
        return [$formation,$cours,$enseignant];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {$data=$this->getData();
        list($formation,$cours,$enseignant)=$data;
        
        return view('pages.association.create',compact('formation','cours','enseignant'));
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
        
        AssociationPartage::create($requestData);

        return redirect('admin/association')->with('flash_message', 'AssociationPartage added!');
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
        $association = AssociationPartage::findOrFail($id);

        return view('pages.association.show', compact('association'));
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
        $association = AssociationPartage::findOrFail($id);
        $data=$this->getData($id);
        list($formation,$cours,$enseignant)=$data;
        return view('pages.association.edit', compact('association','formation','cours','enseignant'));
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
        
        $association = AssociationPartage::findOrFail($id);
        $association->update($requestData);

        return redirect('admin/association')->with('flash_message', 'AssociationPartage updated!');
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
        AssociationPartage::destroy($id);

        return redirect('admin/association')->with('flash_message', 'AssociationPartage deleted!');
    }
}
