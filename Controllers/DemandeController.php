<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Demande;
use App\Models\Administration;
use App\Models\etudiant;
use App\Models\Status;
use App\Models\TypeDemande;

use Illuminate\Http\Request;

class DemandeController extends Controller
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
            $demande = Demande::where('nom','like',"%$keyword%")->paginate($perPage);
        } else {
            $demande = Demande::latest()->paginate($perPage);
        }

        return view('pages.demande.index', compact('demande'));
    }
  
public function  getFormData($id=null){
    $admin=Administration::all();
    $etudiant=etudiant::all();
    $status=Status::all();
    $type=TypeDemande::all();
    return [$admin,$etudiant,$status,$type];
}

public function reponseEtudiant($id){
    $demande=Demande::where('id',$id)->first();
        return view('pages.reponse.home',compact('demande'));

}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {$data=$this->getFormData();
        list($admin,$etudiant,$status,$type)=$data;
        return view('pages.demande.create',compact('admin','etudiant','status','type'));
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
        
        Demande::create($requestData);

        return redirect('admin/demande')->with('flash_message', 'Demande added!');
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
        $demande = Demande::findOrFail($id);

        return view('pages.demande.show', compact('demande'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {$data=$this->getFormData($id);
        list($admin,$etudiant,$status,$type)=$data;
        $demande = Demande::findOrFail($id);

        return view('pages.demande.edit', compact('demande','admin','etudiant','status','type'));
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
        
        $demande = Demande::findOrFail($id);
        $demande->update($requestData);

        return redirect('admin/demande')->with('flash_message', 'Demande updated!');
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
        Demande::destroy($id);

        return redirect('admin/demande')->with('flash_message', 'Demande deleted!');
    }
}
