<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Lecon;
use Illuminate\Http\Request;

class LeconController extends Controller
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
            $lecon = Lecon::where('lecon','like',"%$keyword%")->paginate($perPage);
        } else {
            $lecon = Lecon::latest()->paginate($perPage);
        }

        return view('pages.lecon.index', compact('lecon'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.lecon.create');
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
        
        Lecon::create($requestData);

        return redirect('admin/lecon')->with('flash_message', 'Lecon added!');
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
        $lecon = Lecon::findOrFail($id);

        return view('pages.lecon.show', compact('lecon'));
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
        $lecon = Lecon::findOrFail($id);

        return view('pages.lecon.edit', compact('lecon'));
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
        
        $lecon = Lecon::findOrFail($id);
        $lecon->update($requestData);

        return redirect('admin/lecon')->with('flash_message', 'Lecon updated!');
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
        Lecon::destroy($id);

        return redirect('admin/lecon')->with('flash_message', 'Lecon deleted!');
    }
}
