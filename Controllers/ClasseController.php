<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Classe;
use Illuminate\Http\Request;
use App\Models\Specialty;
use App\Models\Niveau;
use App\Models\diplome;
use App\Models\Groupe;

class ClasseController extends Controller
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
            $classe = Classe::where('libellé','like',"%$keyword%")->paginate($perPage);
        } else {
            $classe = Classe::latest()->paginate($perPage);
        }
        $data=$this->getFormData();
        list($specialty, $niv) = $data;
        return view('pages.classe.index', compact('classe','specialty','niv'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data=$this->getFormData();
        list($specialty, $niv) = $data;
        return view('pages.classe.create',compact('specialty','niv'));
    }

    /**
     * get form data for the contacts form
     *
     *
     *
     * @param null $id
     * @return array
     */
    protected function getFormData($id = null)
    {
        $specialty=Specialty::all();
        $niv=Niveau::all();
        

        return [$specialty, $niv];
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
        
       Classe::create($requestData);

        return redirect('admin/classe')->with('flash_message', 'Classe added!');
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
        $classe = Classe::findOrFail($id);

        return view('pages.classe.show', compact('classe'));
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
        $classe = Classe::findOrFail($id);
        $data=$this->getFormData($id);
        list($specialty, $niv) = $data;
        return view('pages.classe.edit', compact('classe','specialty','niv'));
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
        
        $classe = Classe::findOrFail($id);
        $classe->update($requestData);

        return redirect('admin/classe')->with('flash_message', 'Classe updated!');
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
        Classe::destroy($id);

        return redirect('admin/classe')->with('flash_message', 'Classe deleted!');
    }
}
