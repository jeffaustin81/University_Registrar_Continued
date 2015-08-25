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

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function testGetName()
        {
            //Arrange
            $name = "Bob";
            $date_of_enrollment = "2015-08-15";
            $test_student = new Student($name, $date_of_enrollment);

            //Act
            $result = $test_student->getName();

            //Assert
            $this->assertEquals($name, $result);

        }

        function testSetName()
        {
            //Arrange
            $name = "Bob";
            $date_of_enrollment = "2015-08-15";
            $test_student = new Student($name, $date_of_enrollment);

            //Act
            $test_student->setName('jack');
            $result = $test_student->getName();

            //Assert
            $this->assertEquals('jack', $result);
        }

        function testGetId()
        {
            //Arrange
            $name = "Bob";
            $id = 1;
            $date_of_enrollment = "2015-08-15";
            $test_student = new Student($name, $date_of_enrollment, $id);

            //Act
            $result = $test_student->getId();

            //Assert
            $this->assertEquals($id, $result);

        }

        function testGetDateOfEnrollment()
        {
            //Arrange
            $name = "Bob";
            $date_of_enrollment = "2015-08-15";
            $test_student = new Student($name, $date_of_enrollment);

            //Act
            $result = $test_student->getDateOfEnrollment();

            //Assert
            $this->assertEquals($date_of_enrollment, $result);

        }

        function testSetDateOfEnrollment()
        {
            //Arrange
            $name = "Bob";
            $date_of_enrollment = "2015-08-15";
            $test_student = new Student($name, $date_of_enrollment);

            //Act
            $test_student->setDateOfEnrollment('2014-09-01');
            $result = $test_student->getDateOfEnrollment();

            //Assert
            $this->assertEquals('2014-09-01', $result);
        }

        function testSave()
        {
            //Arrange
            $name = "Bob";
            $date_of_enrollment = "2015-08-15";
            $test_student = new Student($name, $date_of_enrollment);
            $test_student->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals($test_student, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Bob";
            $date_of_enrollment = "2015-08-15";
            $test_student = new Student($name, $date_of_enrollment);
            $test_student->save();

            $name2 = "Jackie";
            $date_of_enrollment2 = "2015-09-16";
            $test_student2 = new Student($name2, $date_of_enrollment2);
            $test_student2->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Bob";
            $date_of_enrollment = "2015-08-15";
            $test_student = new Student($name, $date_of_enrollment);
            $test_student->save();

            $name2 = "Jackie";
            $date_of_enrollment2 = "2015-09-16";
            $test_student2 = new Student($name2, $date_of_enrollment2);
            $test_student2->save();

            //Act
            Student::deleteAll();

            //Assert
            $result = Student::getAll();
            $this->assertEquals([], $result);
        }

        function testUpdateName()
        {
            //Arrange
            $name = "bob";
            $date_of_enrollment = "2015-09-16";
            $test_student = new Student($name, $date_of_enrollment);
            $test_student->save();

            $new_name = "Mark Marvel";
            //Act
            $test_student->updateName($new_name);

            //Assert
            $this->assertEquals("Mark Marvel", $test_student->getName());
        }

        function testUpdateEnrollmentDate()
        {
            //Arrange
            $name = "bob";
            $date_of_enrollment = "2015-09-16";
            $test_student = new Student($name, $date_of_enrollment);
            $test_student->save();

            $new_date = "2015-02-12";
            //Act
            $test_student->updateDateOfEnrollment($new_date);

            //Assert
            $this->assertEquals("2015-02-12", $test_student->getDateOfEnrollment());
        }

        function test_find()
        {
            //Arrange
            $name = "Jack";
            $date_of_enrollment = "2012-02-12";
            $name2 = "Billy";
            $date_of_enrollment2 = "2011-04-14";
            $id = 1;
            $id2 = 2;
            $test_student = new Student($name, $date_of_enrollment, $id);
            $test_student->save();
            $test_student2 = new Student($name2, $date_of_enrollment2, $id2);
            $test_student2->save();

            //Act
            $result = Student::find($test_student->getId());

            //Assert
            $this->assertEquals($test_student, $result);
        }

        function test_addCourse()
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
            $test_student->addCourse($test_course->getId());

            //Assert
            $result = $test_student->getCourses();
            $this->assertEquals([$test_course], $result);
        }

        function test_getCourses()
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

            $name3 = "Philosophy 101";
            $course_number2 = "PHIL101";
            $test_course2 = new Course($name3, $course_number2);
            $test_course2->save();

            //Act
            $test_student->addCourse($test_course->getId());
            $test_student->addCourse($test_course2->getId());

            //Assert
            $result = $test_student->getCourses();
            $this->assertEquals([$test_course, $test_course2], $result);
        }

    }



 ?>
