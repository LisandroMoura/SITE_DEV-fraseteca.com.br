<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contato;
use App\Services\Seo;
use App\Services\ParamGlobal;

class ShowFrontPage extends Controller
{
    public function page($dado, $currentPage = null)
    {           
        $seo=[]; $tabela=[];$seguidor="enable";$tituloPage= "";
        $testaAmp       = ($_SERVER["REQUEST_URI"]); $amp = str_contains($testaAmp,"page/amp/") ? true : false;  
        $usuariologado = Auth::user();        
        $seo            = new Seo;
        $tipo           = "page";

        if($dado=="todas-as-listas"){
            $tabela = DB::table('posts')
            ->where('status', '=',  "1")           
            ->select('posts.id','posts.urlamigavel','posts.capa','posts.thumb','posts.titulo','posts.titulo as descricao','posts.aux_2 as tags.id' )   
            ->orderBy('posts.id', 'desc')                     
            ->paginate(20);
            $tituloPage= "Últimas Listas de Frases";
        }

        if($dado=="frases"){
            $tabela = DB::table('posts')
            ->where('status', '=',  "1")           
            ->select('posts.id','posts.urlamigavel','posts.capa','posts.thumb','posts.titulo','posts.titulo as descricao','posts.aux_2 as tags.id' )   
            ->orderBy('posts.id', 'desc')                     
            ->paginate(50);

            // $tabela = DB::table('frases')
            // ->where('status', '=',  "1")           
            // ->select('frases.id','frases.url_longa_amigavel as urlamigavel','frases.capa','frases.capa as thumb','frases.frase as titulo','frases.frase as descricao','frases.tags as tags.id' )   
            // ->orderBy('frases.id', 'desc')                     
            // ->paginate(50);

            $tipo = "page";
            $tituloPage= "Frases";
        }

        if($dado=="toplistas"){
            $tabela = DB::table('curtidas')
            ->where([
                ['curtidas.tipo', '=', '0'],
                ['posts.status', '=', '1'],
                ])           
            ->join(
            'posts',[
                ['curtidas.post_id', '=', 'posts.id'],
            ]) 
            ->select(DB::raw('count(curtidas.post_id) as curtidas'),'posts.id','posts.urlamigavel','posts.capa','posts.thumb','posts.titulo','posts.titulo as descricao','posts.aux_2 as tags.id' )   
            ->orderBy('curtidas', 'desc')                     
            ->groupBy('posts.id','posts.titulo','posts.urlamigavel','posts.capa','posts.midia_id','posts.thumb' )
            ->paginate(20);            
            $tituloPage= "Top Listas de frases";
            
        }        
        if($dado=="todas-as-tags"){
            $tabela = DB::table('tags')
            ->where([                
                ['tags.status', '=', '1'],
                ])                                   
            ->orderBy('tags.id', 'desc')                                 
            ->paginate(100);            
            $tituloPage= "Todas as tags do site";                        
            $seoParam = $seo->get(null, $dado);      
            
            return view('front.ArchiveShow' , [
                'tabela'    => $tabela, 
                'tituloPage' =>  $tituloPage,
                'tipo'      => "tags",
                'seguindo'   => $seguidor,
                'amp'     =>  $amp,
                'logado'   => $usuariologado,
                'seo'       => $seoParam,          
            ]);
        } 
        if($tabela):
            $seoParam = $seo->get(null, $dado);
            
            return view('front.ArchiveShow' , [
                'tabela'    => $tabela, 
                'tituloPage' =>  $tituloPage,
                'tipo'      => $tipo,
                'seguindo'   => $seguidor,
                'amp'     =>  $amp,
                'logado'   => $usuariologado,
                'seo'       => $seoParam,
                'dado'  => $dado,          
            ]);
        else :
            return response()->view('404', ['exception' => []], 404);
        endif;               
    }
    public function contatoValidate(Request $request)
    {
        $nome       = filter_var($request->all()["nome"], FILTER_SANITIZE_STRING);
        $email      = filter_var($request->all()["email"], FILTER_SANITIZE_STRING);
        $assunto    = filter_var($request->all()["assunto"], FILTER_SANITIZE_STRING);
        $mensagem   = filter_var($request->all()["sua_mensagem"], FILTER_SANITIZE_STRING);
        if(empty($nome)) {
            $empty[] = "<b>Nome</b>";		
        }
        if(empty($email)) {
            $empty[] = "<b>Email</b>";
        }
        if(empty($assunto)) {
            $empty[] = "<b>Assunto</b>";
        }	
        if(empty($mensagem)) {
            $empty[] = "<b>mensagem</b>";
        }
        if(!empty($empty)) {
            $response = [            
                'sucess'    => false,
                'titulo_msg'    => "Xiii",
                'msg'           => "Ops, os campos obrigatórios precisam ser preenchidos!",                  
            ];
            return redirect()->back()->withErrors($response)->withInput();            
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
            $response = [            
                'sucess'    => false,
                'titulo_msg'    => "Xiii",
                'msg'           => "O E-mail informado é inválido :(",
            ];
            return redirect()->back()->withErrors($response)->withInput();            
        }
        
        $paramGlobal  = new ParamGlobal;
        $usaReCaptcha = $paramGlobal->get('arr')['reCaptcha'];
        if($usaReCaptcha=="true"):
            // Fraseteca2023Set03
            if(!isset($request->all()["g-recaptcha-response"])){
                $response = [            
                    'sucess'    => false,
                    'titulo_msg'    => "Xiii",
                    'msg'           => "O código não foi gerado :(",  
                ];
                return redirect()->back()->withErrors($response)->withInput();
            }                    
            $recaptchaResponse = $request->all()["g-recaptcha-response"];
            $result = json_decode($this->validaRecaptcha($recaptchaResponse));        
            if($result->success){
                Mail::to("contato@fraseteca.com.br")->send(new Contato($nome,$email, $assunto, $mensagem));
                $response = [            
                    'sucess'    => true,
                    'titulo_msg'    => "Oba",
                    'msg'           => "Mensagem enviada, logo entraremos em contato :)", 
                ];
                return redirect()->back()->withErrors($response)->withInput();
                // Fraseteca2023Set03
            }
            else {
                $response = [            
                    'sucess'    => false,
                    'titulo_msg'    => "Xiii",
                    'msg'           => "Código inválido :(",                  
                ];
                return redirect()->back()->withErrors($response)->withInput();     
            }
        else:
            Mail::to("contato@fraseteca.com.br")->send(new Contato($nome,$email, $assunto, $mensagem));
            $response = [            
                'sucess'    => true,
                'titulo_msg'    => "Oba",
                'msg'           => "Mensagem enviada, logo entraremos em contato :)",  
                
            ];
            return redirect()->back()->withErrors($response)->withInput();
        endif;
    }
    public function validaRecaptcha($recaptchaResponse)
    {
        $url        = "https://www.google.com/recaptcha/api/siteverify";
        $request = [            
            'secret'    => "6LeG8usfAAAAAAgdE7K4ENG-ylx5YxMMi-omLrUr",
            'response'  => $recaptchaResponse,
            'remoteip'  => $_SERVER['REMOTE_ADDR'],
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request); 
        $exec = curl_exec($ch);
        curl_close($ch);
        return ($exec);
    }        
}