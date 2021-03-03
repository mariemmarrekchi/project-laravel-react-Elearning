<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\posteEnseignant;
use Illuminate\Http\Request;

class PosteEnseignantController extends Controller
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
            $posteenseignant = posteEnseignant::where('poste_enseignant','like',"%$keyword%")->paginate($perPage);
        } else {
            $posteenseignant = posteEnseignant::latest()->paginate($perPage);
        }

        return view('pages.poste-enseignant.index', compact('posteenseignant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.poste-enseignant.create');
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
        
        posteEnseignant::create($requestData);

        return redirect('admin/poste-enseignant')->with('flash_message', 'posteEnseignant added!');
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
        $posteenseignant = posteEnseignant::findOrFail($id);

        return view('pages.poste-enseignant.show', compact('posteenseignant'));
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
        $posteenseignant = posteEnseignant::findOrFail($id);

        return view('pages.poste-enseignant.edit', compact('posteenseignant'));
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
        
        $posteenseignant = posteEnseignant::findOrFail($id);
        $posteenseignant->update($requestData);

        return redirect('admin/poste-enseignant')->with('flash_message', 'posteEnseignant updated!');
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
        posteEnseignant::destroy($id);

        return redirect('admin/poste-enseignant')->with('flash_message', 'posteEnseignant deleted!');
    }
}
