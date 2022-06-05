<?php

class Releve
{
    private $_id; 
    private $_id_student;
    private $_id_faculty;
    private $_id_department;
    private $_id_level;
    private $_id_trail;
    private $_pdf_name;
    private $_pdf_link;
    private $_obtained_at;


    public function __construct(){}

    public function hydrate($info)
    {
        foreach($info as $key => $data){
            $method = 'set' . ucfirst($key);
            if(method_exists($this, $method)){
                $this->$method($data);
            }
        }
    }

    public function getId()
    {
        return $this->_id;
    }
    public function getId_student()
    {
        return $this->_id_student;
    }
    public function getId_faculty()
    {
        return $this->_id_faculty;
    }
    public function getId_department()
    {
        return $this->_id_department;
    }
    public function getId_level()
    {
        return $this->_id_level;
    }
    public function getId_trail()
    {
        return $this->_id_trail;
    }
    public function getPdf_name()
    {
        return $this->_pdf_name;
    }
    public function getPdf_link()
    {
        return $this->_pdf_link;
    }
    public function getObtained_at()
    {
        return $this->_obtained_at;
    }

    public function setId($id)
    {
        $id = (int)$id;
        if($id != 0)
            $this->_id = $id;
    }

    public function setId_student($id)
    {
        $id = (int)$id;
        if($id != 0)
            $this->_id_student = $id;
    }

    public function setId_faculty($id)
    {
        $id = (int)$id;
        if($id != 0)
            $this->_id_faculty = $id;
    }

    public function setId_department($id)
    {
        $id = (int)$id;
        if($id != 0)
            $this->_id_department = $id;
    }

    public function setId_level($id)
    {
        $id = (int)$id;
        if($id != 0)
            $this->_id_level = $id;
    }

    public function setId_trail($id)
    {
        $id = (int)$id;
        if($id != 0)
            $this->_id_trail = $id;
    }

    public function setPdf_name($name)
    {
        if(is_string($name))
            $this->_pdf_name = $name;
    }

    public function setPdf_link($link)
    {
        if(is_string($link))
            $this->_pdf_link = $link;
    }

    public function setObtained_at($date)
    {
        $date = new datetime($date);
        $date = $date->format('Y-m-d');
        $this->_obtained_at = $date;
    }

}

?>