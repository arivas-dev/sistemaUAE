<?php 

require_once realpath (dirname (__FILE__).'/../app/config.php');
/**
 * 
 Nombre de la clase: Pais
 Version: 1.0
 Author: Alexander Rivas
 CopyRigth: Universidad Albert Einstein
 Fecha: 26-11-2018
 *
 */


 class Pais
 {
 	private $id;
	private $nombre;
	public $conectar;
 	function __construct()
 	{
 		$this->con=conectar();
 	}

 	public function getAll()
    {
        $sqlAll = "SELECT * from pais";
        $info = $this->con->query($sqlAll);
        $pais = array();
        if ($info->num_rows>0) {
            
           while ($row = mysqli_fetch_array($info)) {
                $id=$row['id'];
                $nombre=$row['nombre'];
    

                $pais[] = array('id'=> $id, 'text'=> $nombre);
           }
        }else{

            $pais = false;
        }
        return json_encode($pais);
    }
 
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     *
     * @return self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
}

 ?>