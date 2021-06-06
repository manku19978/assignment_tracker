<?php


// read function
function getAssignmentsByCourse($courseId)
{
    global $db;

    if ($courseId) {
        $query = 'SELECT A.ID, A.description, C.courseName 
        FROM assignments A LEFT JOIN courses C ON A.courseID = C.courseID 
        WHERE A.courseID = :course_id ORDER BY A.ID';
    } else {
        $query = 'SELECT A.ID, A.description, C.courseName 
        FROM assignments A LEFT JOIN courses C ON A.courseID = C.courseID 
        ORDER BY C.courseID';
    }

    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $courseId);
    $statement->execute();
    $assignments = $statement->fetchAll();
    $statement->closeCursor();
    return $assignments;
}

function deleteAssignment($assignmentID)
{
    global $db;
    $query = 'DELETE FROM assignments WHERE ID = :assign_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':assign_id', $assignmentID);
    $statement->execute();
    $statement->closeCursor();
}

function addAssignment($courseId, $description)
{
    global $db;
    $query = 'INSERT INTO assignments (description, courseID)
    VALUES (:desc, :courseId)';
    $statement = $db->prepare($query);
    $statement->bindValue(':desc', $description);
    $statement->bindValue(':courseId', $courseId);
    $statement->execute();
    $statement->closeCursor();
}
