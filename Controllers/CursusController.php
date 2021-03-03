<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\diplome;
use App\Models\InscriptionMaster;
use App\Models\Parammention;
use App\Models\Setting;
use App\Models\Specialty;
use App\Models\Cursus;
use App\Models\University;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CursusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        $moyenne=0;
        $inscriptionmaster= InscriptionMaster::where('id_user', Auth::user()->id )->first();
        $cursus= Cursus::where('id_inscription',$inscriptionmaster->id)->get();
        $diplome_cursus= diplome::where('id',$inscriptionmaster->id_diplome)->first();

        if(count($cursus)<=0){
            for($i=0;$i<$diplome_cursus->nb_cursus;$i++){
                $add_cursus= new Cursus();
                $add_cursus->id_inscription=$inscriptionmaster->id;
                $add_cursus->save();
            }
        }
        $cursus= Cursus::where('id_inscription',$inscriptionmaster->id)->get();
        $cursus_moyenne= Cursus::where('id_inscription',$inscriptionmaster->id)
            ->whereNotNull('annee')->get();
        if(count($cursus_moyenne)==$diplome_cursus->nb_cursus){
            foreach ($cursus_moyenne as $cum)
                $moyenne+= floatval( $cum->moyenne);
            $moyenne=$moyenne/$diplome_cursus->nb_cursus;
        }
        $diplome = diplome::whereNull('id_diplome')->get();
        $university = University::all();
        $curent_date=date('Y');
        if($inscriptionmaster->anneeBac)
            $curent_date=$inscriptionmaster->anneeBac+1;
        $param_mention= Parammention::all();
        /*
         * Get last cursus
         */
        $last_cursus=$cursus[count($cursus)-1];
        $setting2=Setting::where('id','4')->first();
        $date_fin=$setting2->setting_value;
        $cache=0;
        $now   = time();

        $date2 = strtotime($date_fin);
        if($date2-$now<0)
            $cache=1;

        return view('pages.cursus.index', compact('cache','moyenne','last_cursus','param_mention','cursus','diplome','university','inscriptionmaster','curent_date'));
    }
    public function validnbdate(Request $request){
        $id=$request->id_inscr;
        $nb_red=$request->txt_redoub;
        $nbr_retr=$request->txt_retrait;
        $inscription= InscriptionMaster::findOrFail($id);
        $inscription->nbr_red =$nb_red;
        $inscription->nbr_retrait = $nbr_retr;
        $inscription->save();
        return redirect('admin/cursus');
    }
    public function autrediplome(Request $request){
        $id=$request->id_inscr;
        $inscription= InscriptionMaster::findOrFail($id);
        if($request->valide){
            $autrespecialite=$request->autrespecialite;
            $txt_autre_diplome=$request->txt_autre_diplome;
            if($autrespecialite)
                $inscription->autrespecialite=$autrespecialite;
            if($txt_autre_diplome)
                $inscription->autrespecialite=$txt_autre_diplome;
        }else{
            $inscription->autrespecialite='';
        }

        $inscription->save();
        return redirect('admin/cursus');
    }
    function getFormData($id=null)
    {
        $inscriptionmastere=InscriptionMaster::all();
        $specialty=Specialty::all();
        return [$inscriptionmastere,$specialty];
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
//    public function create()
//    {
//        $data=$this->getFormData();
//        list($inscriptionmastere,$specialty)=$data;
//                return view('pages.cursus.create',compact('inscriptionmastere','specialty'));
//    }

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
        
        Cursus::create($requestData);

        return redirect('admin/cursus')->with('flash_message', 'Cursus added!');
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
        $cursu = Cursus::findOrFail($id);
        //dd($cursu);
        $inscriptionmaster= InscriptionMaster::where('id',$cursu->id_inscription)->first();

        VerifUserSecurity($inscriptionmaster->id);
        return redirect('admin/cursus');
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

        $data=$this->getFormData($id);
        list($inscriptionmastere,$specialty)=$data;
        $cursu = Cursus::findOrFail($id);

        $inscriptionmaster= InscriptionMaster::where('id',$cursu->id_inscription)->first();
//        dd($inscriptionmaster);
        if($inscriptionmaster)
            VerifUserSecurity($inscriptionmaster->id);
        return redirect('admin/cursus');
//        return view('pages.cursus.edit', compact('cursu','inscriptionmastere','specialty'));
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
        
        $cursu = Cursus::findOrFail($id);


        $inscriptionmaster= InscriptionMaster::where('id',$cursu->id_inscription)->first();
//        dd($inscriptionmaster);
        if($inscriptionmaster)
            VerifUserSecurity($inscriptionmaster->id);
        $cursu->update($requestData);

        return redirect('admin/cursus')->with('flash_message', 'Cursus updated!');
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
        $cursu = Cursus::findOrFail($id);

        $inscriptionmaster= InscriptionMaster::where('id',$cursu->id_inscription)->first();
//        dd($inscriptionmaster);
        if($inscriptionmaster)
            VerifUserSecurity($inscriptionmaster->id);
        Cursus::destroy($id);

        return redirect('admin/cursus')->with('flash_message', 'Cursus deleted!');
    }
    /**
     *
     *
     */
    public function Updatemention( Request $request){
      //  header('Access-Control-Allow-Origin: *');
        $param=$request->json()->all();
        $moyenne=$param['moyenne'];
        $param_mention= Parammention::where('moyen_inf','<=',$moyenne)
            ->where('moyen_sup','>=',$moyenne)->first();
       // dd($param_mention->mention);
        return response()->json([
            'mention'=> $param_mention->mention,
            'mention_id'=> $param_mention->id
        ], 201);
    }
    /**
     *
     *
     */
    public function SaveCursus( Request $request){
        //  header('Access-Control-Allow-Origin: *');
        $param=$request->json()->all();
        $moyenne=str_replace(",",'.',$param['moyenne']);
        $annee=$param['annee'];
        $session=$param['session'];
        $parammention=$param['parammention'];
        $id=$param['id'];
        $cursus= Cursus::where('id',$id)->first();
        $cursus->moyenne=floatval($moyenne);
        $cursus->annee=$annee;
        $cursus->session=$session;
        $cursus->id_parammention=$parammention;
        $cursus->update();
        return response()->json([
            'msg'=> 'Enregistrement avec succées'
        ], 201);
    }
    /**
     *
     * CheckDate
     */
    public function CheckDate( Request $request){

        $param=$request->json()->all();
        $id=$param['id'];
        $cursus=  Cursus::findOrFail($id);
        $list_cursus= Cursus::where('id_inscription',$cursus->id_inscription)
            ->whereNotNull('annee')->orderBy('id','desc')->get();
        $inscriptionmaster= InscriptionMaster::where('id', $cursus->id_inscription )->first();

        if($inscriptionmaster)
            VerifUserSecurity($inscriptionmaster->id);
        $diplome_cursus= diplome::where('id',$inscriptionmaster->id_diplome)->first();
        $nb_date=0;


        if(count($list_cursus)==$diplome_cursus->nb_cursus){

            for($i=0;$i<count($list_cursus)-1;$i++){
                if($list_cursus[$i]->annee - $list_cursus[$i+1]->annee>=2)
                    $nb_date+=$list_cursus[$i]->annee - $list_cursus[$i+1]->annee-1;
            }
        }

        return response()->json([
            'nb_date'=> $nb_date
        ], 201);
    }

    protected function validatorRegistorMaster(array $data)
    {
        return Validator::make($data, [

            'id_diplome'=>'required',
            'date_diplome'=> 'required'

        ]);

    }
    public function updateformdiplome(Request $request){
        $this->validatorRegistorMaster($request->all())->validate();


        $requestData = $request->all();
        $inscription = InscriptionMaster::findOrFail($request->id);
        VerifUserSecurity($inscription->id);
        $inscription->id_diplome=$request->id_diplome;
        $inscription->date_diplome=$request->date_diplome;
        $inscription->id_university_diplome=$request->id_university_diplome;
        $inscription->autre_university_diplome=$request->autre_university_diplome;
        $inscription->autre_diplome=$request->autre_diplome;

        $inscription->save();
        /*
         * Select cursus with compare nb cursus by updated deplome
         */
        $diplome_cursus= diplome::where('id',$inscription->id_diplome)->first();
        $cursus= Cursus::where('id_inscription',$inscription->id)->get();

        if(count($cursus)!=$diplome_cursus->nb_cursus){
            Cursus::where('id_inscription',$inscription->id)->delete();
            for($i=0;$i<$diplome_cursus->nb_cursus;$i++){
                $add_cursus= new Cursus();
                $add_cursus->id_inscription=$inscription->id;
                $add_cursus->save();
            }
            InscriptionMaster::where('id', $inscription->id)
                ->update(['nbr_red' => 0,'nbr_retrait'=>0]);
        }

        return Redirect('admin/cursus');
    }

}
