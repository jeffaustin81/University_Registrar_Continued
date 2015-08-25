<?php

    require_once "src/Student.php";
    require_once "src/Course.php";

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    $server = 'mysql:host=localhost;dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function testGetName()
        {
            //Arrange
            $name = "Philosophy 101";
            $course_number = "PHIL101";
            $test_course = new Course($name, $course_number);

            //Act
            $result = $test_course->getName();

            //Assert
            $this->assertEquals($name, $result);

        }

        function testSetName()
        {
            //Arrange
            $name = "Philosophy 101";
            $course_number = "PHIL101";
            $test_course = new Course($name, $course_number);

            //Act
            $test_course->setName('jack');
            $result = $test_course->getName();

            //Assert
            $this->assertEquals('jack', $result);
        }

        function testGetId()
        {
            //Arrange
            $name = "Philosophy 101";
            $id = 1;
            $course_number = "PHIL101";
            $test_course = new Course($name, $course_number, $id);

            //Act
            $result = $test_course->getId();

            //Assert
            $this->assertEquals($id, $result);

        }

        function testGetCourseNumber()
        {
            //Arrange
            $name = "Philosophy 101";
            $course_number = "PHIL101";
            $test_course = new Course($name, $course_number);

            //Act
            $result = $test_course->getCourseNumber();

            //Assert
            $this->assertEquals($course_number, $result);

        }

        function testSetCourseNumber()
        {
            //Arrange
            $name = "Philosophy 101";
            $course_number = "PHIL101";
            $test_course = new Course($name, $course_number);

            //Act
            $test_course->setCourseNumber('PHIL101');
            $result = $test_course->getCourseNumber();

            //Assert
            $this->assertEquals('PHIL101', $result);
        }

        function testSave()
        {
            //Arrange
            $name = "Psychology 101";
            $course_number = "PSY101";
            $test_course = new Course($name, $course_number);
            $test_course->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals($test_course, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Psychology 101";
            $course_number = "PSY101";
            $test_course = new Course($name, $course_number);
            $test_course->save();

            $name2 = "Psychology 102";
            $course_number2 = "PSY102";
            $test_course2 = new Course($name2, $course_number2);
            $test_course2->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Psychology 101";
            $course_number = "2015-08-15";
            $test_course = new Course($name, $course_number);
            $test_course->save();

            $name2 = "Psychology 102";
            $course_number2 = "PSY102";
            $test_course2 = new Course($name2, $course_number2);
            $test_course2->save();

            //Act
            Course::deleteAll();

            //Assert
            $result = Course::getAll();
            $this->assertEquals([], $result);
        }

        function testUpdateName()
        {
            //Arrange
            $name = "Psychology 101";
            $course_number = "PSY101";
            $test_course = new Course($name, $course_number);
            $test_course->save();

            $new_name = "Psychology 101A";
            //Act
            $test_course->updateName($new_name);

            //Assert
            $this->assertEquals("Psychology 101A", $test_course->getName());
        }

        function testUpdateCourseNumber()
        {
            //Arrange
            $name = "Psychology 101";
            $course_number = "PSY101";
            $test_course = new Course($name, $course_number);
            $test_course->save();

            $new_course_number = "PSY101A";
            //Act
            $test_course->updateCourseNumber($new_course_number);

            //Assert
            $this->assertEquals("PSY101A", $test_course->getCourseNumber());
        }

        function test_find()
        {
            //Arrange
            $name = "Philosophy";
            $course_number = "PHIL101";
            $name2 = "Pyschology";
            $course_number2 = "PSY101";
            $id = 1;
            $id2 = 2;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();
            $test_course2 = new Course($name2, $course_number2, $id2);
            $test_course2->save();

            //Act
            $result = Course::find($test_course->getId());

            //Assert
            $this->assertEquals($test_course, $result);
        }

        function test_addStudent()
        {
            //Arrange
            $name = "bob";
            $date_of_enrollment = "2015-09-16";
            $test_student = new Student($name, $date_of_enrollment);
            $test_student->save();

            $name2 = "Psychology 101";
            $course_number = "PSY101";
            $test_course = new Course($name2, $course_number);
            $test_course->save();

            //Act
            $test_course->addStudent($test_student->getId());

            //Assert
            $result = $test_course->getStudents();
            $this->assertEquals([$test_student], $result);
        }

        function test_getStudents()
        {
            //Arrange
            $name3 = "Psychology 101";
            $course_number = "PSY101";
            $test_course = new Course($name3, $course_number);
            $test_course->save();

            $name = "bob";
            $date_of_enrollment = "2015-09-16";
            $test_student = new Student($name, $date_of_enrollment);
            $test_student->save();

            $name2 = "bill";
            $date_of_enrollment2 = "2015-09-15";
            $test_student2 = new Student($name2, $date_of_enrollment2);
            $test_student2->save();

            //Act
            $test_course->addStudent($test_student->getId());
            $test_course->addStudent($test_student2->getId());

            //Assert
            $result = $test_course->getStudents();
            $this->assertEquals([$test_student, $test_student2], $result);
        }

    }
 ?>
