<?php
namespace Model;

class Usuario extends ActiveRecord{

    protected static $tablas='usuarios';
    protected static $columnasDB=['id','nombre','apellido','email','password','telefono','admin','confirmado','token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    protected static $alertas =[];

    public function __construct($args = [])
    {
        $this->id = $args['id']?? null;
        $this->nombre = $args['nombre']?? '';
        $this->apellido = $args['apellido']?? '';
        $this->email = $args['email']?? '';
        $this->password = $args['password']?? '';
        $this->telefono = $args['telefono']?? '';
        $this->admin = $args['admin']?? null;
        $this->confirmado = $args['confirmado']?? null;
        $this->token = $args['token']?? '';
    }

    public function validarNuevaCuenta(){
        if (!$this->nombre) {
            self::$alertas['error'][]='El nombre del cliente es obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][]='El apellido del cliente es obligatorio';
        }
        return self::$alertas;
    }
}