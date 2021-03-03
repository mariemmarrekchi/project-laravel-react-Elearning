<?php

namespace App\Http\Controllers;

use App\Exports\InscritMasterExport;
use App\Helpers\MailerFactory;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cursus;
use App\Models\InscriptionMaster;
use App\Models\Naturebac;
use App\Models\Setting;
use App\Models\Specialty;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class InscriptionmastereController extends Controller
{
    protected $mailer;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MailerFactory $mailer)
    {

        $this->mailer=$mailer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $keyword1=$request->get('search1');
        $perPage = 25;
        $nb_inscrit=0;
        $cursus_null=json_decode( DB::table('cursus')
            ->select('id_inscription')
            ->whereNull('moyenne')
            ->orwhere('moyenne',0)
            ->groupBy('id_inscription')
            ->get()->toJson(),true);
        //dd(json_encode($cursus_null));
        $cursus= json_decode( DB::table('cursus')
            ->select('id_inscription')

            ->groupBy('id_inscription')
            ->whereNotIn('id_inscription',$cursus_null)
            ->get()->toJson(),true);
        // dd(json_encode($cursus));
        if (!empty($keyword)) {
            $inscriptionmastere = InscriptionMaster::latest()
                ->whereNotNull('id_diplome')
                ->whereNotNull('anneeBac')
                ->whereNotNull('moyenneBac')
                ->whereNotNull('id_speciality')
                ->whereIn('id',$cursus)
                ->where('cin',$keyword)->paginate($perPage);
        } else {
            $inscriptionmastere = InscriptionMaster::latest()
                ->whereNotNull('id_diplome')
                ->whereNotNull('anneeBac')
                ->whereIn('id',$cursus)
                ->whereNotNull('id_speciality')
                ->whereNotNull('moyenneBac')->paginate($perPage);
        }
        if (!empty($keyword1)) {

            $inscrit_valide=json_decode( DB::table('inscriptionmastere')
                ->select('id')
                ->whereNotNull('id_diplome')
                ->whereNotNull('anneeBac')
                ->whereIn('id',$cursus)
                ->whereNotNull('id_speciality')
                ->whereNotNull('moyenneBac')
                ->get()->toJson(),true);
            $inscrit_non_finished=  InscriptionMaster::latest()
                ->whereNotIn('id',$inscrit_valide)
                ->where('cin',$keyword1)
                ->paginate($perPage);
        } else {
            $inscrit_valide=json_decode( DB::table('inscriptionmastere')
                ->select('id')
                ->whereNotNull('id_diplome')
                ->whereNotNull('anneeBac')
                ->whereIn('id',$cursus)
                ->whereNotNull('id_speciality')
                ->whereNotNull('moyenneBac')
                ->get()->toJson(),true);
            $inscrit_non_finished=  InscriptionMaster::latest()
                ->whereNotIn('id',$inscrit_valide)
                ->paginate($perPage);
        }
        $nb_inscrit = InscriptionMaster::whereNotNull('id_diplome')
            ->whereNotNull('anneeBac')
            ->whereNotNull('moyenneBac')
            ->whereIn('id',$cursus)
            ->whereNotNull('id_speciality')
            ->count();

        $nb_inscrit_no_finished = InscriptionMaster::latest()
            ->whereNotIn('id',$inscrit_valide)
            ->count();
        VerifUserSecurity();

        return view('pages.inscriptionmastere.listesinscrit', compact('nb_inscrit_no_finished','inscrit_non_finished','inscriptionmastere','nb_inscrit'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function listsInscript(Request $request)
    {
        $keyword = $request->get('search');
        $keyword1=$request->get('search1');
        $perPage = 25;
        $nb_inscrit=0;
        $cursus_null=json_decode( DB::table('cursus')
            ->select('id_inscription')
            ->whereNull('moyenne')
            ->orwhere('moyenne',0)
            ->groupBy('id_inscription')
            ->get()->toJson(),true);
            //dd(json_encode($cursus_null));
        $cursus= json_decode( DB::table('cursus')
        ->select('id_inscription')

            ->groupBy('id_inscription')
            ->whereNotIn('id_inscription',$cursus_null)
            ->get()->toJson(),true);
       // dd(json_encode($cursus));
        if (!empty($keyword)) {
            $inscriptionmastere = InscriptionMaster::latest()
                ->whereNotNull('id_diplome')
                ->whereNotNull('anneeBac')
                ->whereNotNull('moyenneBac')
                ->whereNotNull('id_speciality')
                ->whereIn('id',$cursus)
                ->where('cin',$keyword)->paginate($perPage);
        } else {
            $inscriptionmastere = InscriptionMaster::latest()
                ->whereNotNull('id_diplome')
                ->whereNotNull('anneeBac')
                ->whereIn('id',$cursus)
                ->whereNotNull('id_speciality')
                ->whereNotNull('moyenneBac')->paginate($perPage);
        }
        if (!empty($keyword1)) {

            $inscrit_valide=json_decode( DB::table('inscriptionmastere')
                ->select('id')
                ->whereNotNull('id_diplome')
                ->whereNotNull('anneeBac')
                ->whereIn('id',$cursus)
                ->whereNotNull('id_speciality')
                ->whereNotNull('moyenneBac')
                ->get()->toJson(),true);
            $inscrit_non_finished=  InscriptionMaster::latest()
                ->whereNotIn('id',$inscrit_valide)
                ->where('cin',$keyword)
                ->paginate($perPage);
        } else {
            $inscrit_valide=json_decode( DB::table('inscriptionmastere')
                ->select('id')
                ->whereNotNull('id_diplome')
                ->whereNotNull('anneeBac')
                ->whereIn('id',$cursus)
                ->whereNotNull('id_speciality')
                ->whereNotNull('moyenneBac')
                ->get()->toJson(),true);
            $inscrit_non_finished=  InscriptionMaster::latest()
                ->whereNotIn('id',$inscrit_valide)
                ->paginate($perPage);
        }
        $nb_inscrit = InscriptionMaster::whereNotNull('id_diplome')
            ->whereNotNull('anneeBac')
            ->whereNotNull('moyenneBac')
            ->whereIn('id',$cursus)
            ->whereNotNull('id_speciality')
            ->count();

        $nb_inscrit_no_finished = InscriptionMaster::latest()
            ->whereNotIn('id',$inscrit_valide)
            ->count();
        VerifUserSecurity();

        return view('pages.inscriptionmastere.listesinscrit', compact('nb_inscrit_no_finished','inscrit_non_finished','inscriptionmastere','nb_inscrit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.inscriptionmastere.create');
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
        
        InscriptionMaster::create($requestData);

        return redirect('admin/inscriptionmastere')->with('flash_message', 'InscriptionMaster added!');
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

        VerifUserSecurity($id);
        $inscriptionmastere = InscriptionMaster::findOrFail($id);

        return view('pages.inscriptionmastere.show', compact('inscriptionmastere'));

    }
    public  function detailuser(){
        $user= Auth::user();

        $inscriptionmastere= InscriptionMaster::where('id_user',$user->id)->first();
        return view('pages.inscriptionmastere.show', compact('inscriptionmastere'));
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
        VerifUserSecurity($id);
        $inscriptionmastere = InscriptionMaster::findOrFail($id);

        return view('pages.inscriptionmastere.edit', compact('inscriptionmastere'));
    }
    public function editprofile()
    {
        $user = Auth::user();
        $inscriptionmastere = InscriptionMaster::where('id_user',$user->id)->first();
        VerifUserSecurity($inscriptionmastere->id);
        $inscriptionmastere = InscriptionMaster::findOrFail($inscriptionmastere->id);

        return view('pages.inscriptionmastere.edit', compact('inscriptionmastere'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'moyenneBac' => 'required|numeric|min:10|max:20'

        ]);

    }
    protected function validatorProfil(array $data)
    {

        return Validator::make($data, [
            'cin' => 'required|numeric',
//            'lieuNaissance' => 'regex:[A-Za-z1-9 ]'
        ]);

    }



    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
//        dd(strip_tags($request->moyenneBac));
        $inscriptionmastere = InscriptionMaster::findOrFail($id);
        if(isset($request->formbac)){
            $this->validator($request->all())->validate();
            $inscriptionmastere->moyenneBac=str_replace(',','.',$request->moyenneBac);

        }

        if(isset($request->formprofil)){

            $this->validatorProfil($request->all())->validate();
            $lieuNaissance = strip_tags($request->input('lieuNaissance'));
            $inscriptionmastere->lieuNaissance=$lieuNaissance;

        }
        if($request->hasFile('photo')){

            checkDirectory('users');
            $requestData['photo']= uploadFile($request,'photo',public_path('uploads/users'));
            $inscriptionmastere->photo=$requestData['photo'];



        }
        $inscriptionmastere->update($requestData);
        $user= User::findOrFail($inscriptionmastere->id_user);
        $user->image=$inscriptionmastere->photo;
        $user->save();

        return redirect('admin/detail')->with('flash_message', 'InscriptionMaster updated!');
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
        InscriptionMaster::destroy($id);

        return redirect('admin/inscriptionmastere')->with('flash_message', 'InscriptionMaster deleted!');
    }
    /**
     * Inscription master form addresse
     */
    public function SetAddrese(Request $request){
        $id_incscrit=$request->id;

        $inscriptionmastere= InscriptionMaster::where('id',$id_incscrit)->first();

        return view('pages.inscriptionmastere.formaddresse', compact('inscriptionmastere'));
    }
    /**
     * Inscription master form addresse
     */
    public function Setbac(Request $request){
        $user= Auth::user();
        $setting2=Setting::where('id','4')->first();
        $date_fin=$setting2->setting_value;
        $cache=0;
        $now   = time();

        $date2 = strtotime($date_fin);
        if($date2-$now<0)
            $cache=1;

        $inscriptionmastere= InscriptionMaster::where('id_user',$user->id)->first();
        $natures= Naturebac::all();
        return view('pages.inscriptionmastere.formbac', compact('inscriptionmastere','natures','cache'));
    }
    /**
     * Inscription master form addresse
     */
    public function Setspecialte(Request $request){
        $id_incscrit=$request->id;

        $inscriptionmastere= InscriptionMaster::where('id',$id_incscrit)->first();
        $specialties=Specialty::all();
        return view('pages.inscriptionmastere.formspecialite', compact('inscriptionmastere','specialties'));
    }
    /**
     * List des mastère
     *
     */
    public function ListMaster(){
        $listmasters= \App\Models\Specialty::where('id_diplome',2)->get();
        $inscriptionmaster = InscriptionMaster::where('id_user',Auth::user()->id)->first();

        return view('pages.specialty.listmastere',compact('listmasters','inscriptionmaster'));
    }
    public function  ValiderChois(Request $request){
        $data=$request->json()->all();
        $inscription= InscriptionMaster::where('id',$data['id'])->first();
        $master= Specialty::where('id',$data['id_master'])->first();
        $inscription->id_speciality=$master->id;
        $inscription->save();
        return response()->json([
            'msg'=> 'votre choix sera confirmé'
        ], 201);
    }
    /***
     *
     *
     * Envoi email score
     */
    public function EnvoiEmailScore(Request $request){
        if(getSetting("enable_email_notification") == 1 ) {
            $inscrit_master= InscriptionMaster::findOrFail($request->id);
            $master= Specialty::where('id', $inscrit_master->id_speciality)->first();
            $mastere_checked=$master->specialty;
            $subject = 'Score Mastère ';

            $user= User::where('id',$inscrit_master->id_user)->first();
            $this->mailer->sendScoreMaster($subject, $user,$mastere_checked,$inscrit_master->ScoreTotal());

        }
        return Redirect('admin/inscriptionmastere');
    }
    /***
     *
     *
     * Envoi email score all inscrit
     */
    public function sendinscrit(Request $request){
        if(getSetting("enable_email_notification") == 1 ) {
            $cursus_null=json_decode( DB::table('cursus')
                ->select('id_inscription')
                ->whereNull('moyenne')
                ->orwhere('moyenne',0)
                ->groupBy('id_inscription')
                ->get()->toJson(),true);
            //dd(json_encode($cursus_null));
            $cursus= json_decode( DB::table('cursus')
                ->select('id_inscription')

                ->groupBy('id_inscription')
                ->whereNotIn('id_inscription',$cursus_null)
                ->get()->toJson(),true);
            // dd(json_encode($cursus));

                $inscrit_master = InscriptionMaster::latest()
                    ->whereNotNull('id_diplome')
                    ->whereNotNull('anneeBac')
                    ->whereNotNull('moyenneBac')
                    ->whereNotNull('id_speciality')
                    ->where('envoi_mail_inscri','!=','1')
                    ->whereIn('id',$cursus)->get();
               // dd(count($inscrit_master).'gg');
            foreach($inscrit_master as $inscrit){
//                if($inscrit->ScoreTotal()>0 &&  $inscrit->envoi_mail_inscri!="1"){
                    $master= Specialty::where('id', $inscrit->id_speciality)->first();
                    $mastere_checked=$master->specialty;
                    $subject = 'Score Mastère ';

                    $user= User::where('id',$inscrit->id_user)->first();
                    $this->mailer->sendScoreMaster($subject, $user,$mastere_checked,$inscrit->ScoreTotal());
                    $inscrit->envoi_mail_inscri="1";
                    $inscrit->save();
//                }
//                else
//                    dd($inscrit);

            }


        }
        return Redirect('admin/inscriptionmastere');
    }

    /***
     *
     *
     * Envoi email score all inscrit
     */
    public function sendinscritnonvalide(Request $request){
        if(getSetting("enable_email_notification") == 1 ) {
            $cursus_null=json_decode( DB::table('cursus')
                ->select('id_inscription')
                ->whereNull('moyenne')
                ->orwhere('moyenne',0)
                ->groupBy('id_inscription')
                ->get()->toJson(),true);
            //dd(json_encode($cursus_null));
            $cursus= json_decode( DB::table('cursus')
                ->select('id_inscription')

                ->groupBy('id_inscription')
                ->whereNotIn('id_inscription',$cursus_null)
                ->get()->toJson(),true);
            // dd(json_encode($cursus));


            $inscrit_valide=json_decode( DB::table('inscriptionmastere')
                ->select('id')
                ->whereNotNull('id_diplome')
                ->whereNotNull('anneeBac')
                ->whereIn('id',$cursus)
                ->whereNotNull('id_speciality')
                ->whereNotNull('moyenneBac')
                ->get()->toJson(),true);
            $inscrit_non_finished=  InscriptionMaster::latest()
                ->whereNotIn('id',$inscrit_valide)
                ->get();
            // dd(count($inscrit_master).'gg');
            foreach($inscrit_non_finished as $inscrit){
//                if($inscrit->ScoreTotal()>0 &&  $inscrit->envoi_mail_inscri!="1"){
                $master= Specialty::where('id', $inscrit->id_speciality)->first();
                $mastere_checked=$master->specialty;
                $subject = 'Score Mastère ';

                $user= User::where('id',$inscrit->id_user)->first();
                $this->mailer->sendScoreMaster($subject, $user,$mastere_checked,$inscrit->ScoreTotal());
                $inscrit->envoi_mail_inscri="1";
                $inscrit->save();
//                }
//                else
//                    dd($inscrit);

            }


        }
        return Redirect('admin/inscriptionmastere');
    }
    public function exportinscritmaster(Request $request){
        $keyword = $request->get('search');
        $perPage = 25;
        $nb_inscrit=0;
        $cursus_null=json_decode( DB::table('cursus')
            ->select('id_inscription')
            ->whereNull('moyenne')
            ->orwhere('moyenne',0)
            ->groupBy('id_inscription')
            ->get()->toJson(),true);
        //dd(json_encode($cursus_null));
        $cursus= json_decode( DB::table('cursus')
            ->select('id_inscription')

            ->groupBy('id_inscription')
            ->whereNotIn('id_inscription',$cursus_null)
            ->get()->toJson(),true);
        // dd(json_encode($cursus));
        if (!empty($keyword)) {
            $inscriptionmastere = InscriptionMaster::latest()
                ->whereNotNull('id_diplome')
                ->whereNotNull('anneeBac')
                ->whereNotNull('moyenneBac')
                ->whereNotNull('id_speciality')
                ->whereIn('id',$cursus)
                ->where('cin',$keyword)->paginate($perPage);
        } else {
            $inscriptionmastere = InscriptionMaster::latest()
                ->whereNotNull('id_diplome')
                ->whereNotNull('anneeBac')
                ->whereIn('id',$cursus)
                ->whereNotNull('id_speciality')
                ->whereNotNull('moyenneBac')->paginate($perPage);
        }
        $nb_inscrit = InscriptionMaster::whereNotNull('id_diplome')
            ->whereNotNull('anneeBac')
            ->whereNotNull('moyenneBac')
            ->whereIn('id',$cursus)
            ->whereNotNull('id_speciality')
            ->count();
        $inscrit_valide=json_decode( DB::table('inscriptionmastere')
            ->select('id')
            ->whereNotNull('id_diplome')
            ->whereNotNull('anneeBac')
            ->whereIn('id',$cursus)
            ->whereNotNull('id_speciality')
            ->whereNotNull('moyenneBac')
            ->get()->toJson(),true);
        $inscrit_non_finished=  InscriptionMaster::latest()
            ->whereNotIn('id',$inscrit_valide)
            ->paginate($perPage);

        VerifUserSecurity();


        return view('pages.inscriptionmastere.exportlist', compact('inscrit_non_finished','inscriptionmastere'));
    }
    public function export($type,$list)
    {

        return \Maatwebsite\Excel\Facades\Excel::download(new InscritMasterExport($list), 'InscritMaster.' . $type);
    }
}
