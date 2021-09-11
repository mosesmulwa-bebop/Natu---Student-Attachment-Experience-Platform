SELECT student.firstname, student.lastname , attachment.name_of_company
FROM student
INNER JOIN attachment
ON student.id = attachment.studentid;