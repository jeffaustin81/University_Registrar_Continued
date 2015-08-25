<?php

    class Student
    {
        //Properties
        private $name;
        private $id;
        private $date_of_enrollment;

        //Constructor
        function __construct($name, $id = null, $date_of_enrollment)
        {
            $this->name = $name;
            $this->id = $id;
            $this->date_of_enrollment = $date_of_enrollment;
        }

        //Name setter and getter
        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        //id getter
        function getid()
        {
            return $this->id;
        }

        //enrollment getter and setter
        function getDateOfEnrollment()
        {
            return $this->date_of_enrollment;
        }

        function setDateOfEnrollment($new_date)
        {
            $this->date_of_enrollment = $new_date;
        }

    }
?>
