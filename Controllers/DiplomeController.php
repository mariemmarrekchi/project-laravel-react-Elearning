<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\diplome;
use Illuminate\Http\Request;
use App\Models\Specialty;
class DiplomeController extends Controller
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
            $diplome = diplome::where('diplome','like',"%$keyword%")
                ->whereNull('id_diplome')->paginate($perPage);
        } else {
            $diplome = diplome::whereNull('id_diplome')->paginate($perPage);
        }

        return view('pages.diplome.index', compact('diplome'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $specialty=Specialty::all();
        $diplomes = diplome::all();
        return view('pages.diplome.create',compact('specialty','diplomes'));
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
        
    diplome::create($requestData);

        return redirect('admin/diplome')->with('flash_message', 'diplome added!');
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
        $diplome = diplome::findOrFail($id);
        $diplomes= diplome::whereNull('id_diplome')->get();
        return view('pages.diplome.show', compact('diplome','diplomes'));
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
        $diplome = diplome::findOrFail($id);
        $diplomes= diplome::all();

        return view('pages.diplome.edit', compact('diplome','diplomes'));
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
        
        $diplome = diplome::findOrFail($id);
        $diplome->update($requestData);

        return redirect('admin/diplome')->with('flash_message', 'diplome updated!');
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
        diplome::destroy($id);

        return redirect('admin/diplome')->with('flash_message', 'diplome deleted!');
    }
}
