<?php
/**
 *
 * @About:      Database connection manager class
 * @File:       Database.php
 * @Date:       $Date:$ Mar-2020
 * @Version:    $Rev:$ 1.0
 * @Developer:  Raul Pardo
 
 **/
 
class Cliente {

    public $conn;

    function __construct() {
        require_once 'DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
    function get_productos($param){
       $sentencia=$this->conn->prepare("SELECT idproductos, tipo_producto, empresa_fiscal, fecha_creacion, fecha_edicion, ultimo_estado, persona_contratante, anyo FROM productos INNER JOIN clientes ON productos.clientes_idclientes = clientes.idclientes WHERE clientes_idclientes = ? AND red_idred = ?");
       $sentencia->bindParam(1,$param['idcliente']);
       $sentencia->bindParam(2,$param['red']);
       $sentencia->execute();
       $result = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
       if($sentencia->rowCount() > 0){
           $response = array();
           $response[0] = true;
           $response[1] = $sentencia->fetchAll();
           return $response;
        }else{
           $response = array();
           $response[0] = false;
           $response[1] = "No hay registros para mostrar";
           return $response;
        }
    }
    
    function get_producto($idprod){
       $sentencia=$this->conn->prepare("SELECT tipo_producto, anyo FROM productos WHERE idproductos = ?");
       $sentencia->bindParam(1,$idprod);
       $sentencia->execute();
       $result = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
       if($sentencia->rowCount() > 0){
           $response = array();
           $response[0] = true;
           $response[1] = $sentencia->fetchAll();
           return $response;
        }else{
           $response = array();
           $response[0] = false;
           $response[1] = "No hay registros para mostrar";
           return $response;
        }
    }
    
    function get_total_prods($param){
       $sentencia=$this->conn->prepare("SELECT COUNT(*) as total FROM productos WHERE clientes_idclientes = ? AND red_idred = ?");
       $sentencia->bindParam(1,$param['idcliente']);
       $sentencia->bindParam(2,$param['red']);
       $sentencia->execute();
       $result = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
       if($sentencia->rowCount() > 0){
           $response = array();
           $response[0] = true;
           $response[1] = $sentencia->fetchAll();
           return $response;
        }else{
           $response = array();
           $response[0] = false;
           $response[1] = "No hay registros para mostrar";
           return $response;
        }
    }
    
    function get_total_prods_hechos($param){
       $sentencia=$this->conn->prepare("SELECT COUNT(*) as si FROM productos WHERE clientes_idclientes = ? AND red_idred = ? AND (ultimo_estado = 'hecho' OR ultimo_estado = 'generico' OR ultimo_estado = 'completoverificacion')");
       $sentencia->bindParam(1,$param['idcliente']);
       $sentencia->bindParam(2,$param['red']);
       $sentencia->execute();
       $result = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
       if($sentencia->rowCount() > 0){
           $response = array();
           $response[0] = true;
           $response[1] = $sentencia->fetchAll();
           return $response;
        }else{
           $response = array();
           $response[0] = false;
           $response[1] = "No hay registros para mostrar";
           return $response;
        }
    }
    
    function get_total_prods_no_hechos($param){
       $sentencia=$this->conn->prepare("SELECT COUNT(*) as no FROM productos WHERE clientes_idclientes = ? AND red_idred = ? AND (ultimo_estado != 'hecho' AND ultimo_estado != 'generico' AND ultimo_estado != 'completoverificacion')");
       $sentencia->bindParam(1,$param['idcliente']);
       $sentencia->bindParam(2,$param['red']);
       $sentencia->execute();
       $result = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
       if($sentencia->rowCount() > 0){
           $response = array();
           $response[0] = true;
           $response[1] = $sentencia->fetchAll();
           return $response;
        }else{
           $response = array();
           $response[0] = false;
           $response[1] = "No hay registros para mostrar";
           return $response;
        }
    }
    
    function get_total_documentos($param){
       $cif = $param['cif'];
       $red = $param['red'];
       $path = $_SERVER["DOCUMENT_ROOT"].'/test.serviciosdeconsultoria.es/users/'.$cif.'/'.$red.'/';
       $fi = new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS);

       $response = array();
       $response[0] = true;
       $response[1] = iterator_count($fi);
       return $response;
    }
    
    function get_total_documentos_by_prod($param){
       $cif = $param['cif'];
       $red = $param['red'];
       $prod = $param['prod'];
       $path = $_SERVER["DOCUMENT_ROOT"].'/test.serviciosdeconsultoria.es/users/'.$cif.'/'.$red.'/'.$prod.'/';
       $fi = new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS);

       $response = array();
       $response[0] = true;
       $response[1] = iterator_count($fi);
       return $response;
    }
    
    function get_all_data($idcliente){
       $sentencia=$this->conn->prepare("SELECT razon, direccion,poblacion,provincia,cp,email,tlf,movil FROM clientes WHERE idclientes = ?");
       $sentencia->bindParam(1,$idcliente);
       $sentencia->execute();
       $result = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
       if($sentencia->rowCount() > 0){
           $response = array();
           $response[0] = true;
           $response[1] = $sentencia->fetchAll();
           return $response;
        }else{
           $response = array();
           $response[0] = false;
           $response[1] = "No hay registros para mostrar";
           return $response;
        }
    }
        
    function get_all_user($iduser){
       $sentencia=$this->conn->prepare("SELECT user, pw FROM users WHERE idusers = ?");
       $sentencia->bindParam(1,$iduser);
       $sentencia->execute();
       $result = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
       if($sentencia->rowCount() > 0){
           $response = array();
           $response[0] = true;
           $response[1] = $sentencia->fetchAll();
           return $response;
        }else{
           $response = array();
           $response[0] = false;
           $response[1] = "No hay registros para mostrar";
           return $response;
        }
    }
        
    function update_user($param){
       $sentencia=$this->conn->prepare("UPDATE users SET user=?, pw=? WHERE idusers = ?");
       $sentencia->bindParam(1,$param['user']);
       $sentencia->bindParam(2,$param['pw']);
       $sentencia->bindParam(3,$param['idusers']);
       $sentencia->execute();
       $result = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
       if($sentencia->rowCount() > 0){
           $response = array();
           $response[0] = true;
           $response[1] = 'Actualizado correctamente';
           return $response;
        }else{
           $response = array();
           $response[0] = false;
           $response[1] = "Error al actualizar";
           return $response;
        }
    }
        
    function update_cliente($param){
       $sentencia=$this->conn->prepare("UPDATE clientes SET razon=?, direccion=? ,poblacion=? ,provincia=? ,cp=? ,email=? ,tlf=? ,movil=? WHERE idclientes = ?");
       $sentencia->bindParam(1,$param['razon']);
       $sentencia->bindParam(2,$param['direccion']);
       $sentencia->bindParam(3,$param['poblacion']);
       $sentencia->bindParam(4,$param['provincia']);
       $sentencia->bindParam(5,$param['cp']);
       $sentencia->bindParam(6,$param['email']);
       $sentencia->bindParam(7,$param['tlf']);
       $sentencia->bindParam(8,$param['movil']);
       $sentencia->bindParam(9,$param['idclientes']);
       $sentencia->execute();
       $result = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
       if($sentencia->rowCount() > 0){
           $response = array();
           $response[0] = true;
           $response[1] = 'Actualizado correctamente';
           return $response;
        }else{
           $response = array();
           $response[0] = false;
           $response[1] = "Error al actualizar";
           return $response;
        }
    }

    function get_archivos_privados($param) {
        $sentencia = $this->conn->prepare("SELECT id, nombre, ruta, fecha_subida FROM archivos_privados WHERE idclientes = ?  ORDER BY fecha_subida DESC");
        $sentencia->bindParam(1, $param['idcliente']);
        $sentencia->execute();
        $result = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        if($sentencia->rowCount() > 0) {
            $response = array();
            $response[0] = true;
            $response[1] = $sentencia->fetchAll();
            return $response;
        } else {
            $response = array();
            $response[0] = false;
            $response[1] = "No hay archivos para mostrar";
            return $response;
        }
    }

    function get_archivo_privado($id) {
        $sentencia = $this->conn->prepare("SELECT ruta FROM archivos_privados WHERE id = ?");
        $sentencia->bindParam(1, $id);
        $sentencia->execute();
        $result = $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        if($sentencia->rowCount() > 0) {
            $response = array();
            $response[0] = true;
            $response[1] = $sentencia->fetchAll();
            return $response;
        } else {
            $response = array();
            $response[0] = false;
            $response[1] = "Archivo no encontrado";
            return $response;
        }
    }

    function delete_archivo_privado($id) {
        $sentencia = $this->conn->prepare("DELETE FROM archivos_privados WHERE id = ?");
        $sentencia->bindParam(1, $id);
        $sentencia->execute();
        if($sentencia->rowCount() > 0) {
            $response = array();
            $response[0] = true;
            $response[1] = "Archivo eliminado correctamente";
            return $response;
        } else {
            $response = array();
            $response[0] = false;
            $response[1] = "Error al eliminar el archivo";
            return $response;
        }
    }

    function save_archivo_privado($param) {
        $sentencia = $this->conn->prepare("INSERT INTO archivos_privados (clientes_idclientes, red_idred, nombre, ruta, tipo, fecha_subida) VALUES (?, ?, ?, ?, ?, NOW())");
        $sentencia->bindParam(1, $param['idcliente']);
        $sentencia->bindParam(2, $param['red']);
        $sentencia->bindParam(3, $param['nombre']);
        $sentencia->bindParam(4, $param['ruta']);
        $sentencia->bindParam(5, $param['tipo']);
        $sentencia->execute();
        if($sentencia->rowCount() > 0) {
            $response = array();
            $response[0] = true;
            $response[1] = "Archivo guardado correctamente";
            return $response;
        } else {
            $response = array();
            $response[0] = false;
            $response[1] = "Error al guardar el archivo";
            return $response;
        }
    }
}

?>
