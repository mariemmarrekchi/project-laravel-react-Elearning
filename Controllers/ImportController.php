<?php

   

namespace App\Http\Controllers;

  

use App\Helpers\MailerFactory;
use App\User;
use Illuminate\Http\Request;

use App\Exports\UserExport;

use App\Imports\UsersImport;

use Maatwebsite\Excel\Facades\Excel;//biblothéque 
use App\Models\Enseignant;
  

class ImportController extends Controller

{

    /**

    * @return \Illuminate\Support\Collection

    */
    protected $mailer;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MailerFactory $mailer)
    {
       session()->forget('teachers');
        $this->mailer=$mailer;
    }
    public function importExportView()
    {
        $teachers=[];
       return view('pages.import.importEnseignant',compact('teachers'));

    }

   

    /**

    * @return \Illuminate\Support\Collection

    */

    public function export() 

    {

        return Excel::download(new UserExport, 'nationalité.xlsx');

    }

   

    /**

    * @return \Illuminate\Support\Collection

    */

    public function import()
    {
        $teachers=[];
        if(request()->file('file')){
            $data= Excel::toArray(new UsersImport,request()->file('file'));
            if($data&&count($data)>0){
                $teachers=$data[0];
                unset($teachers[0]);
                session(['teachers'=>$teachers]);
                return view('pages.import.importEnseignant',compact('teachers'));
            }

        }


          return view('pages.import.importEnseignant',compact('teachers'));

    }
    public function sauvgardeimport(){
            if(session('teachers')){
                $teachers=session('teachers');
                foreach ($teachers as $teacher){
                    if($teacher[0]&&$teacher[0]!='')
                    $enseignant= Enseignant::where('matricule',$teacher[0])->first();
                    $user= User::where('name',$teacher[3])
                        ->orwhere('email',$teacher[4])->first();
                    if(!$enseignant&&!$user){
                        $id=User::create([
                            'name'=> $teacher[3],
                            'password'=> bcrypt($teacher[5]),
                            'pw'=>$teacher[5],
                            'email'=> $teacher[4],
                            'is_admin'=>0,
                            'is_active'=>1
                        ])->id;
                        $user=User::findOrFail($id);
                        //assign student role id
                        $user->syncRoles(3);
                        Enseignant::create([
                            'matricule'=>$teacher[0],
                            'nom'=> $teacher[1],
                            'prenom'=> $teacher[2],
                            'email'=> $teacher[4],
                            'tel'=> $teacher[6],
                            'id_user'=>$id

                        ]);
                        if(getSetting("enable_email_notification") == 1 ) {
                            $subject='Inscription à FSJPST espace enseignant';

                            $this->mailer->sendUpdateRoleEmail($subject, $user);
                        }
                    }
                }
            }
        $teachers=[];
        return redirect('/importExportView')->with('flash_message', 'Importation terminée');
    }

}
