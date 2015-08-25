<?php
    // This is the initial setup for the app.php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Course.php";
    require_once __DIR__."/../src/Student.php";

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=registrar';
    $username = 'root';
    $password = 'root';

    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('students' => Student::getAll(), 'courses' => Course::getAll()));
    });

    $app->get("/courses", function() use ($app) {
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->post("/courses", function() use ($app) {
        $name = $_POST['name'];
        $course_number = $_POST['course_number'];
        $course = new Course($name, $course_number, $id = null);
        $course->save();

        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    $app->get("/courses/{id}", function($id) use ($app) {
        $course = Course::find($id);

        return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->get("/courses/{id}/edit", function($id) use ($app) {
        $course = Course::find($id);

        return $app['twig']->render('course_edit.html.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->patch("/edit_course/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $course_number = $_POST['course_number'];
        $id = $_POST['course_id'];
        $course = Course::find($id);
        $course->updateName($name);
        $course->updateCourseNumber($course_number);

        return $app['twig']->render('course.html.twig', array('course' => $course, 'courses' => Course::getAll(), 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->get("/students", function() use ($app) {
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->post("/students", function() use ($app) {
        $name = $_POST['name'];
        $date_of_enrollment = $_POST['date_of_enrollment'];
        $student = new Student($name, $date_of_enrollment, $id = null);
        $student->save();

        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/students/{id}", function($id) use ($app) {
        $student = Student::find($id);

        return $app['twig']->render('student.html.twig', array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });


    return $app;
?>
