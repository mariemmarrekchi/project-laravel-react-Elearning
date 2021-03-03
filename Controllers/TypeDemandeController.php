<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\TypeDemande;
use Illuminate\Http\Request;

class TypeDemandeController extends Controller
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
            $typedemande = TypeDemande::where('libellé','like',"%$keyword%")()->paginate($perPage);
        } else {
            $typedemande = TypeDemande::latest()->paginate($perPage);
        }

        return view('pages.type-demande.index', compact('typedemande'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.type-demande.create');
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
        
        TypeDemande::create($requestData);

        return redirect('admin/type-demande')->with('flash_message', 'TypeDemande added!');
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
        $typedemande = TypeDemande::findOrFail($id);

        return view('pages.type-demande.show', compact('typedemande'));
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
        $typedemande = TypeDemande::findOrFail($id);

        return view('pages.type-demande.edit', compact('typedemande'));
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
        
        $typedemande = TypeDemande::findOrFail($id);
        $typedemande->update($requestData);

        return redirect('admin/type-demande')->with('flash_message', 'TypeDemande updated!');
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
        TypeDemande::destroy($id);

        return redirect('admin/type-demande')->with('flash_message', 'TypeDemande deleted!');
    }
}
