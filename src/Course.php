<?php

    class Course
    {
        private $name;
        private $course_number;
        private $id;


        function __construct($name, $course_number, $id = null)
        {
            $this->name = $name;
            $this->course_number = $course_number;
            $this->id = $id;
        }

        //Set and Get for name
        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        //Set and Get for course number
        function getCourseNumber()
        {
            return $this->course_number;
        }

        function setCourseNumber($new_course_number)
        {
            $this->course_number = $new_course_number;
        }

        //Get id
        function getId()
        {
            return $this->id;
        }

        //Save Method
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO
                courses (name, course_number)
                VALUES ('{$this->getName()}', '{$this->getCourseNumber()}')");

            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //Get all method
        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses");
            $courses = array();
            foreach($returned_courses as $course) {
                $name = $course["name"];
                $course_number = $course["course_number"];
                $id = $course["id"];
                $new_course = new Course($name, $course_number, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        //Delete All
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses");
        }

        //Update course name
        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET name = '{$new_name}'
                WHERE id = {$this->getId()}");

            $this->setName($new_name);
        }

        //Update course enrollment date
        function updateCourseNumber($new_course_number)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET course_number = {$new_course_number}
                WHERE id = {$this->getId()}");

            $this->setCourseNumber($new_course_number);
        }

        //Find course
        static function find($search_id)
        {
            $found_course = null;
            $courses = Course::getAll();
            foreach($courses as $course) {
                $course_id = $course->getId();
                if ($course_id == $search_id) {
                    $found_course = $course;
                }
            }
            return $found_course;
        }
    }


 ?>
