<?php
namespace App\Http\Controllers;
use App\User;
use App\UserType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'tipo_documento'   => 'required|string',
            'numero_documento' => 'required|string|unique:personas',
            'nombre'           => 'required|string',
            'apellido'         => 'required|string',
            'direccion'        => 'required|string',
            'telefono'         => 'required|string',
            'correo'           => 'required|string|email|unique:personas',
            'genero'           => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'password'         => 'required|string|confirmed'
        ],[
            'numero_documento.unique'   => 'El número de documento ya se encuentra registrado',
            'correo.unique'             => 'Este correo ya se encuentra registrado'
        ]);
        $idTipo_usuario = UserType::where(['nombre_tipo_usuario' => 'paciente'])->value('id_tipo');
        $user = new User([
            'tipo_documento'   => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'nombre'           => strtolower($request->nombre),
            'apellido'         => strtolower($request->apellido),
            'direccion'        => $request->direccion,
            'ciudad'           => $request->ciudad,
            'telefono'         => $request->telefono,
            'correo'           => strtolower($request->correo),
            'genero'           => $request->genero,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'tipo_usuario'     => $idTipo_usuario,
            'password'         => bcrypt($request->password),
            'estado'           => 'a'
        ]);
        $user->save();
        return response()->json([
            'message' => 'Se ha registrado correctamente!'], 201);
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'correo'      => 'required|string|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $credentials = request(['correo', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Usuario o contraseña incorrecta'], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        return response()->json([
            'id' => $user->id,
            'nombre' => $user->nombre,
            'apellido' =>$user->apellido,
            'User_type' => UserType::where(['id_tipo' => $user->tipo_usuario])->value('nombre_tipo_usuario'),
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                    ->toDateTimeString(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 
            'Se ha cerrado la sesion de forma satisfactoria']);
    }

}