<?php

function getCourses()
{
    global $db;
    $query = 'SELECT * FROM courses ORDER BY courseID';
    $statement = $db->prepare($query);
    $statement->execute();
    $courses = $statement->fetchAll();
    $statement->closeCursor();
    return $courses;
}


function getCourseName($courseId)
{
    if (!$courseId) {
        return "All Courses";
    }

    global $db;
    $query = 'SELECT * FROM courses WHERE courseID = :course_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $courseId);
    $statement->execute();
    $course = $statement->fetch();
    $statement->closeCursor();
    $courseName = $course['courseName'];
    return $courseName;
}

function deleteCourse($courseId)
{
    global $db;
    $query = 'DELETE FROM courses WHERE courseID = :course_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $courseId);
    $statement->execute();
    $statement->closeCursor();
}

function addCourses($courseName)
{
    global $db;
    $query = 'INSERT INTO courses (courseName) VALUES (:courseName)';
    $statement = $db->prepare($query);
    $statement->bindValue(':courseName', $courseName);
    $statement->execute();
    $statement->closeCursor();
}
