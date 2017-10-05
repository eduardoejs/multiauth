<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        // middleware "guest" - nao permite que acesse o dashboard de administracao enquanto estiver logado como usuario
        // middleware "guest:admin" - isso nos permite acessar este formulário, mesmo que estivéssemos logados como
        //                            um usuário, porque ainda somos convidados no administrador
        //redireciona para login se a pessoa nao estiver logada como admin
        // o array como segundo parametro é para que o middleware "guest" nao seja aplicado ao acessar o logout
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('auth.login-admin');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
           'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Attempt to login the user
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)){
            // If successful, then redirect to their intened location
            return redirect()->intended(route('admin.dashboard'));
        }

        // If unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
