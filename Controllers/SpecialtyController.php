<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\diplome;
use App\Models\InscriptionMaster;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
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
            $specialty = Specialty::where('specialty','like',"%$keyword%")->paginate($perPage);
        } else {
            $specialty = Specialty::latest()->paginate($perPage);
        }

        return view('pages.specialty.index', compact('specialty'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data=$this->getFormData();
        list($diplomes)=$data;
        return view('pages.specialty.create',compact('diplomes'));
    }
    function getFormData($id=null)
    {

        $diplomes= diplome::all();
        return [$diplomes];
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
        
        Specialty::create($requestData);

        return redirect('admin/specialty')->with('flash_message', 'Specialty added!');
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
        $specialty = Specialty::findOrFail($id);

        return view('pages.specialty.show', compact('specialty'));
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
        $specialty = Specialty::findOrFail($id);
        $data=$this->getFormData();
        list($diplomes)=$data;
//        dd($diplomes);
        return view('pages.specialty.edit', compact('specialty','diplomes'));
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
        
        $specialty = Specialty::findOrFail($id);
        $specialty->update($requestData);

        return redirect('admin/specialty')->with('flash_message', 'Specialty updated!');
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
        Specialty::destroy($id);

        return redirect('admin/specialty')->with('flash_message', 'Specialty deleted!');
    }
}
