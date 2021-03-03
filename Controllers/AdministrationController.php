<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Administration;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
class AdministrationController extends Controller
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
            $administration = Administration::where('matricule', 'like', "%$keyword%")->paginate($perPage);
        } else {
            $administration = Administration::latest()->paginate($perPage);
        }
// print_r($request->file());
        return view('pages.administration.index', compact('administration'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = User::all();
        return view('pages.administration.create',compact("user"));
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
        // $requestData = $request->except(['_token']);

        // checkDirectory("administration");

        
        $requestData = $request->all();
     
        
        Administration::create($requestData);
        // $user= User::all();
        return redirect('admin/administration')->with('flash_message', 'Administration added!');
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
        $administration = Administration::findOrFail($id);

        return view('pages.administration.show', compact('administration'));
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
        $administration = Administration::findOrFail($id);

        return view('pages.administration.edit', compact('administration'));
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
        
        $administration = Administration::findOrFail($id);
       

        return redirect('admin/administration')->with('flash_message', 'Administration updated!');
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
      Administration::destroy($id);

        return redirect('admin/administration')->with('flash_message', 'Administration deleted!');
    }
}
