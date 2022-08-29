<?php
namespace App;

class Person{
    public $name;

    public function setName($name,$age){
        $this->name = $name;
        $this->age = $age;
    }

    public function getName(){
        return $this->name.','.$this->age;
    }
}

?>