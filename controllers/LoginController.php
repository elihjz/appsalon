<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    
    public static function login(Router $router){
        $alertas =[];

        // $auth = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // var_dump($_POST);
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            // dd($auth);
            // dd($alertas);
            if (empty($alertas)) {
                $usuario = Usuario::where('email',$auth->email);
                // dd($usuario);
                // var_dump($usuario);
                if ($usuario) {
                    $usuario->comprobarPasswordAndVerificado($auth->password);

                    $_SESSION['id'] =$usuario->id;
                    $_SESSION['nombre'] =$usuario->nombre." ".$usuario->apellido;
                    $_SESSION['email'] =$usuario->email;
                    $_SESSION['login'] =true;

                    if ($usuario->admin === "1") {
                        $_SESSION['admin'] = $usuario->admin ?? null;
                        dd('Adminuser');
                        header('Location: /admin');
                    }else{
                        dd('Es cliente');
                        header('Location: /cita');
                    }
                }else{
                    Usuario::setAlerta('error','Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login',[
            'alertas' => $alertas
            // 'auth' => $auth
        ]);
    }
    
    public static function logout(){
        echo "desde logout";
    }
    
    public static function olvide(Router $router){
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            dd($auth);
        }

        $router->render('/auth/olvide-password',[
            'alertas' => $alertas
        ]);
    }
    
    public static function recuperar(){
        echo "desde recuperar";
    }
    
    public static function crear(Router $router){
        $usuario = new Usuario;

        $alertas =[];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

        if(empty($alertas)) {
            $resultado = $usuario->existeUsuario();
            // dep($resultado);
            if ($resultado->num_rows) {
                $alertas = Usuario::getAlertas();
            }else{
                $usuario->hashPassword();
                $usuario->crearToken();
                $email = new Email($usuario->nombre,$usuario->email,$usuario->token);
                $email->enviarConfirmacion();
                $resultado = $usuario->guardar();
                // dep($resultado);
                // die;
                if ($resultado) {
                    header('Location: /mensaje');
                }
            }
        }

        }


        $router->render('auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){
        $alertas =[];

        $token =s($_GET['token']);
        
        $usuario = Usuario::where('token',$token);

        if(empty($usuario)) {
            Usuario::setAlerta('error','Token no valido');
        }else{
            $usuario->confirmado = '1';//aqui accedemos a los objetos de usuario y reasignamos valores para guardar
            $usuario->token = null;
            // dd($usuario);
            // die();
            $usuario->guardar();
            Usuario::setAlerta('exito','Cuenta comprobada correctamente');
        }
        // dd($usuario);
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta',[
            'alertas' => $alertas
        ]);
    }

}