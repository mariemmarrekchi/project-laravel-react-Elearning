<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Avis;
use Illuminate\Http\Request;
use App\Models\Administration;

class AvisController extends Controller
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
            $avis = Avis::where('titre','like',"%$keyword%")->paginate($perPage);
        } else {
            $avis = Avis::latest()->paginate($perPage);
        }

        return view('pages.avis.index', compact('avis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {$admin=Administration::all();
        return view('pages.avis.create',compact('admin'));
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
        
        Avis::create($requestData);

        return redirect('admin/avis')->with('flash_message', 'Avis added!');
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
        $avi = Avis::findOrFail($id);

        return view('pages.avis.show', compact('avi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {$admin=Administration::all();
        $avi = Avis::findOrFail($id);

        return view('pages.avis.edit', compact('avi','admin'));
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
        
        $avi = Avis::findOrFail($id);
        $avi->update($requestData);

        return redirect('admin/avis')->with('flash_message', 'Avis updated!');
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
        Avis::destroy($id);

        return redirect('admin/avis')->with('flash_message', 'Avis deleted!');
    }
}
