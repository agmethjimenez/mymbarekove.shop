<?php


Class Categoria{
    public static function getCategorias($conexion){
        $sql = 'SELECT*FROM categorias';
        $result = $conexion->prepare($sql);
        $result->execute();

        $categorias = $result->fetchAll(PDO::FETCH_ASSOC);
        return $categorias;
    }
}
?>