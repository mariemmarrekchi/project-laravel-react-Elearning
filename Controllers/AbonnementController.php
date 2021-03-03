<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Abonnement;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // $keyword = $request->get('search');
        // $perPage = 25;

        // if (!empty($keyword)) {
        //     $abonnement = Abonnement::latest()->paginate($perPage);
        // } else {
        //     $abonnement = Abonnement::latest()->paginate($perPage);
        // }

        // return view('abonnement.index', compact('abonnement'));
        $abonnement = Abonnement::all();
        return response()->json($abonnement, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('abonnement.create');
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
        
        Abonnement::create($requestData);

        return response()->json($requestData, 200);
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
        $abonnement = Abonnement::findOrFail($id);

        return $abonnement->toJson();
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
        $abonnement = Abonnement::findOrFail($id);

        return$abonnement->toJson();
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
        
        $abonnement = Abonnement::findOrFail($id);
        $abonnement->update($requestData);

        return response()->json($abonnement, 200);
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
        Abonnement::destroy($id);

        return 200;
    }
}
