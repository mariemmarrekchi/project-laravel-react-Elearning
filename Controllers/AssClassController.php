<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\AssClass;
use App\Models\Classe;
use App\Models\AssociationPartage;
use Illuminate\Http\Request;

class AssClassController extends Controller
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
            $assclass = AssClass::latest()->paginate($perPage);
        } else {
            $assclass = AssClass::latest()->paginate($perPage);
        }

        return view('pages.ass-class.index', compact('assclass'));
    }
    public function getData($id=null){
        $class=Classe::all();
        $assPart=AssociationPartage::all();
       
        return [$class,$assPart];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {$data=$this->getData();
        list($class,$assPart)=$data;
        return view('pages.ass-class.create',compact('class','assPart'));
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
        
        AssClass::create($requestData);

        return redirect('admin/ass-class')->with('flash_message', 'AssClass added!');
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
        $assclass = AssClass::findOrFail($id);

        return view('pages.ass-class.show', compact('assclass'));
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
        $assclass = AssClass::findOrFail($id);
        $data=$this->getData($id);
        list($class,$assPart)=$data;
        return view('pages.ass-class.edit', compact('assclass','class','assPart'));
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
        
        $assclass = AssClass::findOrFail($id);
        $assclass->update($requestData);

        return redirect('admin/ass-class')->with('flash_message', 'AssClass updated!');
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
        AssClass::destroy($id);

        return redirect('admin/ass-class')->with('flash_message', 'AssClass deleted!');
    }
}
