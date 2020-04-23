<?php

namespace projetoGCA\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\UrlGenerator;
use Auth;

class MyMailController extends Controller
{
    public function emailCompartilhar(Request $request){
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($request->grupoConsumoId);
        $coordenador = \projetoGCA\User::find($grupoConsumo->coordenador_id);

        $link = route('compartilhar.get',$grupoConsumo->id);

        $consumidores = $grupoConsumo->consumidores;
        foreach($consumidores as $consumidor){
            $consumidor_user = \projetoGCA\User::find($consumidor->user_id);
            if($consumidor_user->email == $request->email){
                return back()->with('fail',('Usuário já cadastrado na seu Grupo de Consumo'));
            }
        }

        $to_name = 'Convidado';
        $to_email = $request->email;
        $data = array(
            'coordenador' => $coordenador,
            'grupoConsumo' => $grupoConsumo,
            'link' => $link,
        );

        $subject = 'Feira Solidária - Grupo Consumo '.$grupoConsumo->name;
        
        Mail::send('emails.mail_share', $data, function($message) use ($to_name, $to_email, $subject) {
            $message->to($to_email, $to_name)
                    ->subject($subject);
            $message->from('naoresponder.lmts@gmail.com','Feira Solidária');
        });

        return back()->with('success',('Enviado para '.$to_email));
    }
 
    public function enviarEmail(Request $request){
        $input = $request->input();
        

        $to_name = $input["nomes"];
        $to_email = $input["emails"];
        $coordenador = \Auth::user();        
        $grupo_consumo = $input['grupo_consumo'];
                
        $data = array(
            'mensagem' => $input["mensagem"],        
        );

        $subject = $input["assunto"];        

        Mail::send("emails.mail_grupo", $data, function($message) use ($to_name, $to_email, $subject, $coordenador) {
            $message->to($to_email, $to_name)                    
                    ->subject($subject);
            $message->from('naoresponder.lmts@gmail.com', $coordenador->name);            
            $message->replyTo($coordenador->email, $coordenador->name);
        });

        return redirect("/consumidores/$grupo_consumo")->with('success','Email enviado');
       
    }
}

