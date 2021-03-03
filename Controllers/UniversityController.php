<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    /**
     * Display a University of FSJPST.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $count_university=  University::all();
        if(count($count_university)>0){
            $university=University::where('is_university',0)->first();
            if($university)
                return view('pages.university.edit', compact('university'));
        }

        return view('pages.university.create');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function indexuniversity(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $university = University::where('raison_social','like',"%$keyword%")
                ->where('is_university',1)->paginate($perPage);
        } else {
            $university = University::where('is_university',1)->paginate($perPage);
        }


         return view('pages.university.index',compact('university'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.university.create');
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
        
        University::create($requestData);

        return redirect('admin/university')->with('flash_message', 'University added!');
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
        $university = University::findOrFail($id);

        return view('pages.university.show', compact('university'));
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
        $university = University::findOrFail($id);

        return view('pages.university.edit', compact('university'));
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
        
        $university = University::findOrFail($id);
        if ($request->hasFile('logo')) {

            checkDirectory("university/");

            $requestData['logo'] = uploadFile($request, 'logo', public_path('uploads/university'));
        }

        if ($request->hasFile('logo_petit')) {

            checkDirectory("university/");

            $requestData['logo_petit'] = uploadFile($request, 'logo_petit', public_path('uploads/university'));
        }
        $university->update($requestData);
        if($university->is_university==0)
        return redirect('admin/university')->with('flash_message', 'Université mise à jour!');
        else
            return redirect('admin/universityall')->with('flash_message', 'Université mise à jour!');
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
        University::destroy($id);

        return redirect('admin/university')->with('flash_message', 'University deleted!');
    }
}
