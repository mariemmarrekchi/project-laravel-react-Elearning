<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\MailerFactory;
use App\Models\diplome;
use App\Models\etudiant;
use App\Models\InscriptionMaster;
use App\Models\Mailbox;
use App\Models\Setting;
use App\Models\University;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    protected $mailer;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MailerFactory $mailer)
    {
        $this->middleware('guest');
        $this->mailer=$mailer;
    }
    public function showRegistrationForm(Request $request)
    {

        $step=1;
        $key='';
        return view('auth.register',compact('step','key'));
    }
    public function registeraccount(Request $request){

        $step=2;
        $key='';
        return view('auth.register',compact('step','key'));
    }
    public function Activatedaccount(Request $request){


        $step=$request->step;
        $key=$request->key;
        $user=User::findOrFail($key);
        $user->is_active=1;
        $user->save();
        return view('auth.login');
    }
    public function register(Request $request){

            $this->validator($request->all())->validate();

            $user= User::where('email',$request->email)->first();

            if(!$user && $request->step==1) {

                $id= User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone' => $request->tel,
                    'is_active' => 0,
                    'is_admin' => 0
                ])->id;
                $user=User::findOrFail($id);
                //assign student role id
                $user->syncRoles(2);


                // send role update notification
                if(getSetting("enable_email_notification") == 1 ) {
                    $subject = 'Incription Administartion FSJPST';

                    $body = 'Votre compte a été désactivé pour accéder au système d\'administration FSJPST  
                     <a href="'.url('/registeraccount/'.$user->id.'/2').'"> complétez votre inscription</a>';


                   $mailbox = new Mailbox();

                   $mailbox->subject = $subject;
                   $mailbox->body = $body;
                   $mailbox->sender_id = 1;
                   $mailbox->time_sent = date("Y-m-d H:i:s");
                   $mailbox->parent_id = 0;

                   $mailbox->save();
                   $this->mailer->sendMailboxEmail($mailbox);
                }
                return redirect('register')->with('flash_message', 'consultez votre adresse email et complétez votre inscription!');

            }else{
            etudiant::create([
                'matricule'=> $request->matricule,
                'nom'=> $request->nom,
                'prenom'=> $request->prenom,
                'email'=> $request->email,
                'tel'=> $request->tel,
                'id_user'=> $request->key,
                'id_class'=> $request->classe
            ]);
                return redirect('login')->with('flash_message', 'Votre inscription est terminée ');
            }




    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    /**
     * @param
     * @return view
     * function registor master from student
     *
     */
    protected function registermaster(){

        $setting2=Setting::where('id','4')->first();
        $date_fin=$setting2->setting_value;

        $now   = time();

        $date2 = strtotime($date_fin);
        if( $date2 -$now<=0){
            return Redirect('login');
        }
        $step=1;
        $key='';
        $diplome = diplome::whereNull('id_diplome')->get();
        $university = University::all();
        return view('auth.registermaster',compact('step','key','diplome','university'));
    }
    protected function registerformmaster(Request $request){

        $this->validatorRegistorMaster($request->all())->validate();


        $requestData = $request->all();
        $inscription= new InscriptionMaster();
        $inscription->cin=$request->cin;
        $inscription->reference=rand(10000,99999);
        $inscription->nomFr=$request->namefr;
        $inscription->prenomFr=$request->prenomfr;

        $inscription->nomAr=$request->namear;
        $inscription->prenomAr=$request->prenomar;
        $inscription->dateNaissance=$request->datenn;
        $inscription->lieuNaissance=$request->lieunn;
        $inscription->adresse=$request->addr;
        $inscription->email=$request->email;
        $inscription->id_diplome=$request->id_diplome;
        $inscription->date_diplome=$request->date_diplome;
        $inscription->id_university_diplome=$request->id_university_diplome;
        $inscription->autre_university_diplome=$request->autre_university_diplome;
        $inscription->autre_diplome=$request->autre_diplome;

        if($request->hasFile('photo')){
//            checkDirectory('etudiant');
//
//
//
//            $requestData['photo']=uploadFile($request,'photo',public_path('uploads/etudiant'));
           // dd($requestData['photo']);
            checkDirectory('users');
            $requestData['photo']= uploadFile($request,'photo',public_path('uploads/users'));
            $inscription->photo=$requestData['photo'];



        }
        $id= User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->tel,
            'image'=>$requestData['photo'],
            'is_active' => 0,
            'is_admin' => 0
        ])->id;
        $user=User::findOrFail($id);

        $user->syncRoles(4);

        $inscription->id_user=$id;
        $inscription->tel=$request->tel;





        $inscription->save();



        // send role update notification
        if(getSetting("enable_email_notification") == 1 ) {
            $subject = 'Incription en master Administartion FSJPST';



            $this->mailer->sendActivatedInscriptionMaster($subject, $user,$request->password);

        }
        $step=3;
        $key=$user->id;
        return view('auth.registermaster',compact('step','key'));
    }
    protected function validatorRegistorMaster(array $data)
    {
        return Validator::make($data, [
//            'img' => 'required',
            'cin' => 'required|string|max:8|unique:inscriptionmastere',
            'namefr' => 'required|string|min:2',
            'prenomfr'=>'required|string|min:2',
            'namear' => 'required|string|min:2',
            'prenomar'=>'required|string|min:2',
            'datenn'=>'required|date',
            'lieunn'=>'required',
            'email'=>'required|string|email|max:255|unique:users',
            'tel'=>'required|unique:inscriptionmastere',
           // 'captcha' => 'required|captcha',
            'name'=> 'required|unique:users',
            'password' => 'required',
            'step'=> 'required',
            'id_diplome'=>'required',
            'date_diplome'=> 'required'

        ]);

    }
    protected function validator(array $data)
    {
       if($data['step']&&$data['step']==1){
           return Validator::make($data, [
               'name' => 'required|string|max:255',
               'email' => 'required|string|email|max:255|unique:users',
               'password' => 'required|string|min:6|confirmed',
               'captcha' => 'required|captcha',
               'step'=> 'required'

           ]);
       }else{
           return Validator::make($data, [
               'nom'=> 'required',
               'prenom'=> 'required',
               'matricule'=> 'required',
               'tel'=>'required|max:8',
               'step'=> 'required',
               'key'=> 'required',
               'captcha' => 'required|captcha',
               ]);
       }


    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


}
