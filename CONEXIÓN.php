<?php
 class BD{
    private static $instancia=NULL;

    public static function crearInstancia(){
        if(!isset(self::$instancia)){
            $opcionesPDO[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
        self::$instancia=new PDO('mysql:host=<localhost:3304></localhost:3304>;dbname=db_empleados','root','',$opcionesPDO);
        echo"Conexion Exitosa";
        }
        return self::$instancia;
    }
 }