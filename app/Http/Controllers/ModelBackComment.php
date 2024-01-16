<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Exceptions\ValidatorException;
use App\Http\Requests\CommentCreateRequest;
use Illuminate\Http\Request;
use App\Entities\Comment;
use App\Entities\CommentFrases;
use App\Services\Sanitize; //tirari isso 
use App\Services\Mensagens;

use function Psy\debug;

class ModelBackComment extends Controller
{
    protected $service_mensagens;
    public function __construct(Mensagens  $service_mensagens)
    {
        $this->service_mensagens = $service_mensagens;
    }
    public function store(CommentCreateRequest $request)
    {

        $mensagens_cadastro = $this->service_mensagens->mensagens_cadastro;
        $usuariologado = Auth::user();
        if (!$usuariologado) {
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => "Qur tal Fazer login?",
                'msg'           => "parece que você não está logado no sistema, para comentar é preciso fazer loguin :(",
            ];
            return redirect()->back()->withErrors($retorno);
        }
        $request["autor_email"] = $usuariologado->email;
        $request["autor_nome"]  = $usuariologado->nome_completo;

        $validated = $request->validate([
            'body'            => 'required',
            'autor_email'     => 'required|email',
            'autor_nome'      => 'required'
        ]);

        try {
            $dados                  = $request->all();
            $sanitize               = new Sanitize;
            $dados["autor_nome"]    = $sanitize->run($dados["autor_nome"]);
            $dados["body"]          = $sanitize->run($dados["body"]);

            echo '<pre>';
            print_r($dados);
            echo '</pre>';
            if ($request["table"] == "comment_frases") {
                $comment = new CommentFrases;
                $comment->parent_id         = $dados["parent_id"];
                $comment->frases_id         = $dados["frase_id"];
                $comment->status            = $dados["status"];
                $comment->autor_email       = $dados["autor_email"];
                $comment->autor_nome        = $dados["autor_nome"];
                $comment->usuario_id        = $dados["usuario_id"];
                $comment->body              = $dados["body"] ?? "";
                // $comment->autor_post_id     = "123";
                $comment->autor_ip          = $dados["autor_ip"] ?? "";
                $comment->save();

            } else
                $comment = Comment::create($dados);
            $retorno = [
                'sucesso'       => true,
                'titulo_msg'    => $mensagens_cadastro['titulo_sucesso'],
                'msg'           => $mensagens_cadastro['comment_sucesso'],
            ];
        } catch (\Throwable $e) {

            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => $mensagens_cadastro['titulo_erro'],
                'msg'           => $mensagens_cadastro['comment_erro'],

            ];
        }
        return redirect()->back()->withErrors($retorno);
    }
    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'body'            => 'required',
            'autor_email'     => 'required|email',
            'autor_nome'      => 'required'
        ]);

        $mensagens_cadastro = $this->service_mensagens->mensagens_cadastro;
        try {
            $dados                  = $request->all();
            $sanitize               = new Sanitize;
            $dados["autor_nome"]    = $sanitize->run($dados["autor_nome"]);
            $dados["body"]          = $sanitize->run($dados["body"]);
            if ($request["table"] == "comment_frases") {
                $comment = CommentFrases::find($id);
                if ($comment) {
                    $comment->body              = $dados["body"];
                    $comment->status            = $dados["status"];
                    $comment->aux_1             = $dados["aux_1"];
                    $comment->aux_2             = $dados["aux_2"];
                    $comment->save();
                    $retorno = [
                        'sucesso'       => true,
                        'titulo_msg'    => $mensagens_cadastro['titulo_sucesso'],
                        'msg'           => $mensagens_cadastro['update_sucesso'],
                    ];
                } else {
                    $retorno = [
                        'sucesso'       => false,
                        'titulo_msg'    => "ops",
                        'msg'           => "algo deu erado",
                    ];
                }
                if ($request->wantsJson()) return response()->json($retorno);
                return redirect()->back()->withErrors($retorno);
            }
            $tabela = Comment::find($id);
            $tabela->update($dados);
            $retorno = [
                'sucesso'       => true,
                'titulo_msg'    => $mensagens_cadastro['titulo_sucesso'],
                'msg'           => $mensagens_cadastro['update_sucesso'],
            ];
            if ($request->wantsJson()) return response()->json($retorno);
            return redirect()->back()->withErrors($retorno);
        } catch (ValidatorException $e) {
            $retorno = [
                'sucesso'       => false,
                'titulo_msg'    => $mensagens_cadastro['titulo_erro'],
                'msg'           => $mensagens_cadastro['update_erro'],
            ];
            if ($request->wantsJson()) return response()->json($retorno);
            return redirect()->back()->withErrors($retorno);
        }
    }

    public function edit($id)
    {
        $comment = Comment::find($id);
        return view('comments.edit', compact('comment'));
    }
    public function destroy($id)
    {

        $deleted = Comment::find($id);
        if ($deleted)
            $deleted->delete();
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Comment deleted.',
                'deleted' => $deleted,
            ]);
        }
        $retorno = [
            'sucesso'     => true,
            'titulo_msg'  => 'Certo!',
            'msg'         => 'Registro Deletado',
        ];
        return redirect()->back()->withErrors($retorno);
    }
}
