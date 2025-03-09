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
            self::$alertas['error'][]='El nombre es obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][]='El apellido es obligatorio';
        }
        if (!$this->telefono) {
            self::$alertas['error'][]='El telefono es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][]='El email es obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][]='El password es obligatorio';
        }
        if (strlen($this->password)<6) {
            self::$alertas['error'][]='El password minimo requerido es de 6 caracteres obligatorio';
        }
        return self::$alertas;
    }

    public function existeUsuario(){
        $query=" SELECT * FROM " . self::$tablas . " WHERE email = '".$this->email. "' LIMIT 1";
        
        $resultado = self::$db->query($query);
        // dep($resultado);
        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya esta registrado';
        }

        return $resultado;
        // dep($resultado);
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
}