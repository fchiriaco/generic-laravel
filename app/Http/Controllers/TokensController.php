<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TokensController extends Controller
{

    public function tokens()
    {
        return Inertia::render('Tokens/index');
    } 

    public function crea_Token(Request $request)
    {
        $t = $request->user()->createToken($request->token_name,$request->token_abilities);
        $token = DB::table('personal_access_tokens')->select('id','name','token','abilities')->where('tokenable_id',Auth::id())->where('name',$request->token_name)->orderBy('id','desc')->get();
        $token['ptext'] = $t->plainTextToken;
        return $token;

    }

    public function del_Token(Request $request,$id)
    {
        $tokenable_id = DB::table('personal_access_tokens')->find($id)->tokenable_id;
        if (! Gate::allows('delete-token', $tokenable_id)) {
            abort(403);
        }
        DB::table('personal_access_tokens')->where('id',$id)->delete();
        return "Record Cancellato correttamente";

    }

    public function lista_Tokens()
    {
        $tokens = DB::table('personal_access_tokens')->select('id','name','token','abilities')->where('tokenable_id',Auth::id())->get();
        return $tokens;

    }

}
