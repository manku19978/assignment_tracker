<?php

require('model/database..php');
require('model/assignments_db.php');
require('model/course_db.php');

$assignmentId = filter_input(INPUT_POST, 'assignmentId', FILTER_VALIDATE_INT);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
$courseName = filter_input(INPUT_POST, 'courseName', FILTER_SANITIZE_STRING);

$courseId = filter_input(INPUT_POST, 'courseId', FILTER_VALIDATE_INT);
if (!$courseId) {
    $courseId = filter_input(INPUT_GET, 'courseId', FILTER_VALIDATE_INT);
}

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if (!$action) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
    if (!$action) {
        $action = 'list_assignments';
    }
}

switch ($action) {
    case "list_courses":
        $courses = getCourses();
        include('view/course_list.php');
        break;
    case "add_course":
        addCourses($courseName);
        header("Location: .?action=list_courses");
        break;
    case "add_assignment":
        if ($courseId && $description) {
            addAssignment($courseId, $description);
            header("Location: .?courseId=$courseId");
        } else {
            $error = "Invalid assignment data. Check all fields and try again";
            include('view/error.php');
            exit();
        }
        break;
    case "delete_course":
        if ($courseId) {
            try {
                deleteCourse($courseId);
            } catch (PDOException $e) {
                $error = "You cannot delete a course if assignments exists in the course.";
                include("view/error.php");
                exit();
            }
            header("Location: .?action=list_courses");
        }
        break;
    case "delete_assignment":
        if ($assignmentId) {
            deleteAssignment($assignmentId);
            header("Location: .?courseId=$courseId");
        } else {
            $error = "Missing or incorrect assignment id";
            include("view/error.php");
        }
        break;
    default:
        $courseName = getCourseName($courseId);
        $courses = getCourses();
        $assignments = getAssignmentsByCourse($courseId);
        include('view/assignment_list.php');
}
