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

        //Find student
        static function find($search_id)
        {
            $found_student = null;
            $students = Student::getAll();
            foreach($students as $student) {
                $student_id = $student->getId();
                if ($student_id == $search_id) {
                    $found_student = $student;
                }
            }
            return $found_student;
        }

        //Add course
        function addCourse($course_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO students_courses (student_id, course_id)
                VALUES ({$this->getId()}, {$course_id}) ");

        }

        //Get Courses
        function getCourses()
        {
            $returned_courses = $GLOBALS['DB']->query(
            "SELECT courses.* FROM students JOIN students_courses
            ON (students.id = students_courses.students_id)
            JOIN courses ON (students_courses.courses_id = courses.id)
            WHERE students.id = {$this->getId()};");
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
        

    }
?>
