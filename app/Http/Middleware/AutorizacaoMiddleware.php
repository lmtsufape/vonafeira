<?php

namespace projetoGCA\Http\Middleware;

use Closure;
use Auth;

class AutorizacaoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($request->route('id'));
        if(\Auth::guest() || \Auth::user()->id != $grupoConsumo->coordenador_id){
            return redirect("login");
        }

        return $next($request);
    }
}
