<?php

namespace Model;

class ActiveRecord {

    protected static $db;
    protected static $columnasDB =[];
    protected static $tablas = '';

    protected static $errores =[];
    protected static $alertas =[];
    
    public static function setDB($database){
        self::$db = $database;
    }

    public function guardar(){
        $resultado = '';
        if(!is_null($this->id)){
            $resultado = $this->actualizar();
        }else{
            $resultado = $this->crear();
        }
        return $resultado;
    }

    public function crear(){
        $atributos = $this->sanitizarAtributos();
        
        $query = "INSERT INTO ".static::$tablas. " ( ";
        $query.= join(', ', array_keys($atributos));
        $query.= " ) VALUES (' ";
        $query.= join("', '", array_values($atributos));
        $query.= "')";
        // dd($query);
        $resultado = self::$db->query($query);
        if ($resultado) {
            header('Location: /mensaje');
        }
    }

    public function actualizar(){
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value){
            $valores[]="{$key}='{$value}'";
        }
        // dep($valores);
        $query = "UPDATE ".static::$tablas." SET "; 
        $query .=join(', ',$valores);
        $query .="WHERE id='".self::$db->escape_string($this->id)."'" ;
        $query .=" LIMIT 1;";
        // dep($query);
        ob_start();
        $resultado = self::$db->query($query);
        if ($resultado){
            header('location: /');
            exit;
        }
    }

    public function eliminar(){
        $query = "DELETE FROM ".static::$tablas." WHERE id =".self::$db->escape_string($this->id)." LIMIT 1";
        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
    }

    public function atributos(){//Identifica y une los atributos de la BD
        $atributos = [];
        foreach(static::$columnasDB as $columna){
            if($columna === 'id') continue;
            $atributos[$columna] =  $this->$columna;
        }
        return $atributos;
    }
    
    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public function borrarImagen(){
        $existeArchivo = file_exists(CARPETA_IMAGENES.$this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES.$this->imagen);
        }
    }

    public static function getErrores(){
        return self::$errores;
    }

    public function validar(){
        static::$errores = [];
        return static::$errores;
    }

    public function setImagen($imagen){
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    public static function all(){
        $query = "SELECT * FROM ".static::$tablas;
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    public static function get($cantidad){
        $query = "SELECT * FROM ". static::$tablas." LIMIT ". $cantidad;

        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function setAlerta($tipo, $mensaje){
        static::$alertas[$tipo][]=$mensaje;
    }

    public static function getAlertas(){
        return static::$alertas;
    }

    public static function consultarSQL($query){
        $resultado = self::$db->query($query);

        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        $resultado->free();

        return $array;
    }

    public static function find($id){
        $query = "SELECT * FROM ".static::$tablas." WHERE id = ${id}";

        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }
    public static function where($columna, $valor){
        $query = "SELECT * FROM ".static::$tablas." WHERE ${columna} = '${valor}'";
        dd($query);
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function crearObjeto($registro){
        $objeto = new static;
        
        foreach ($registro as $key => $value) {
            if (property_exists($objeto,$key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    public function sincronizar($args = []){
        foreach($args as $key => $value){
            if (property_exists($this, $key)&& !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

}