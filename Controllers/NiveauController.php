<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Niveau;
use App\Models\Specialty;
use App\Models\diplome;
use Illuminate\Http\Request;

class NiveauController extends Controller
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
            $niveau = Niveau::where('niveau','like',"%$keyword%")->paginate($perPage);
        } else {
            $niveau = Niveau::latest()->paginate($perPage);
        }

        return view('pages.niveau.index', compact('niveau'));
    }
    function getFormData($id=null)
    {
        $specialty=Specialty::all();
        $diplome=diplome::all();
        return [$specialty,$diplome];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {$data=$this->getFormData();
        list($specialty,$diplome) = $data;
        return view('pages.niveau.create',compact('specialty','diplome'));
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
        
        Niveau::create($requestData);

        return redirect('admin/niveau')->with('flash_message', 'Niveau added!');
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
        $niveau = Niveau::findOrFail($id);

        return view('pages.niveau.show', compact('niveau'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {$data=$this->getFormData();
        list($specialty,$diplome) = $data;
        return view('pages.niveau.edit',compact('specialty','diplome'));
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
        
        $niveau = Niveau::findOrFail($id);
        $niveau->update($requestData);

        return redirect('admin/niveau')->with('flash_message', 'Niveau updated!');
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
        Niveau::destroy($id);

        return redirect('admin/niveau')->with('flash_message', 'Niveau deleted!');
    }
}
