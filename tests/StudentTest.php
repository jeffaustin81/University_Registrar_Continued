<?php

    require_once "src/Student.php";

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
            //Course::deleteAll();
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

    }



 ?>
