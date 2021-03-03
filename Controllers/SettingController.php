<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
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
            $setting = Setting::latest()->paginate($perPage);
        } else {
            $setting = Setting::latest()->paginate($perPage);
        }

        return view('pages.setting.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.setting.create');
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
        
        Setting::create($requestData);

        return redirect('admin/setting')->with('flash_message', 'Setting added!');
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
        $setting = Setting::findOrFail($id);

        return view('pages.setting.show', compact('setting'));
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
        $setting = Setting::findOrFail($id);

        return view('pages.setting.edit', compact('setting'));
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
        
        $setting = Setting::findOrFail($id);
        $setting->update($requestData);

        return redirect('admin/setting')->with('flash_message', 'Setting updated!');
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
        Setting::destroy($id);

        return redirect('admin/setting')->with('flash_message', 'Setting deleted!');
    }
    /**
     *
     * Calcul diff between tow date angular js
     */
    public function DiffBetTowDate(){
        $setting1= Setting::where('id',3)->first();
        $date_debit=$setting1->setting_value;
        $setting2=Setting::where('id','4')->first();
        $date_fin=$setting2->setting_value;

        $now   = time();
//       dd($now);
        $date2 = strtotime($date_fin);
        $diffr=dateDiff($now,$date2);
        return response()->json([
             $diffr
        ], 201);
    }
}
