<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Naturebac;
use Illuminate\Http\Request;

class NatureBacController extends Controller
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
            $naturebac = Naturebac::latest()->paginate($perPage);
        } else {
            $naturebac = Naturebac::latest()->paginate($perPage);
        }

        return view('pages.naturebac.index', compact('naturebac'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.naturebac.create');
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
        
        Naturebac::create($requestData);

        return redirect('admin/naturebac')->with('flash_message', 'Naturebac added!');
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
        $naturebac = Naturebac::findOrFail($id);

        return view('pages.naturebac.show', compact('naturebac'));
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
        $naturebac = Naturebac::findOrFail($id);

        return view('pages.naturebac.edit', compact('naturebac'));
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
        
        $naturebac = Naturebac::findOrFail($id);
        $naturebac->update($requestData);

        return redirect('admin/naturebac')->with('flash_message', 'Naturebac updated!');
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
        Naturebac::destroy($id);

        return redirect('admin/naturebac')->with('flash_message', 'Naturebac deleted!');
    }
}
