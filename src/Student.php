<?php

    class Student
    {
        //Properties
        private $name;
        private $id;
        private $date_of_enrollment;

        //Constructor
        function __construct($name, $date_of_enrollment, $id = null)
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

        //Save Method
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO
                students (name, date_of_enrollment)
                VALUES ('{$this->getName()}', '{$this->getDateOfEnrollment()}')");

            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //Get all method
        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students");
            $students = array();
            foreach($returned_students as $student) {
                $name = $student["name"];
                $date_of_enrollment = $student["date_of_enrollment"];
                $id = $student["id"];
                $new_student = new Student($name, $date_of_enrollment, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

        //Delete All
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students");
        }

        //Update student name
        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE students SET name = '{$new_name}'
                WHERE id = {$this->getId()}");

            $this->setName($new_name);
        }

        //Update student enrollment date
        function updateDateOfEnrollment($new_date)
        {
            $GLOBALS['DB']->exec("UPDATE students SET date_of_enrollment = {$new_date}
                WHERE id = {$this->getId()}");

            $this->setDateOfEnrollment($new_date);
        }

    }
?>
