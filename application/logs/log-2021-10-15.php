<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

[MySchool] - 2021-10-15 00:08:29 --> Query error: Unknown column 'period' in 'where clause' - Invalid query: SELECT student_id, full_name FROM v_enroll 
																																	WHERE class_id = '3'
																																	AND year = '2021'
																																	AND period = '4'                                                                                      
																																	GROUP BY student_id
																																	ORDER BY full_name
																																	
[MySchool] - 2021-10-15 00:08:42 --> Severity: error --> Exception: Cannot use object of type mysqli as array /home4/dhcoder9/myschool.dhcoder.com/application/views/backend/admin/students.php 143
[MySchool] - 2021-10-15 00:09:17 --> Severity: error --> Exception: Cannot use object of type mysqli as array /home4/dhcoder9/myschool.dhcoder.com/application/views/backend/admin/students.php 143
[MySchool] - 2021-10-15 00:09:19 --> Severity: error --> Exception: Cannot use object of type mysqli as array /home4/dhcoder9/myschool.dhcoder.com/application/views/backend/admin/students.php 143
[MySchool] - 2021-10-15 00:21:03 --> Severity: Warning --> DOMDocument::loadHTML(): htmlParseCharRef: invalid xmlChar value 2013266057 in Entity, line: 1 /home4/dhcoder9/myschool.dhcoder.com/application/libraries/PHPExcel/Reader/HTML.php 495
[MySchool] - 2021-10-15 00:21:03 --> Severity: Warning --> DOMDocument::loadHTML(): Invalid char in CDATA 0x1A in Entity, line: 2 /home4/dhcoder9/myschool.dhcoder.com/application/libraries/PHPExcel/Reader/HTML.php 495
[MySchool] - 2021-10-15 00:31:34 --> 404 Page Not Found: Public/style
[MySchool] - 2021-10-15 00:50:53 --> Severity: Warning --> sizeof(): Parameter must be an array or an object that implements Countable /home4/dhcoder9/myschool.dhcoder.com/application/models/Crud.php 1241
[MySchool] - 2021-10-15 16:45:07 --> Severity: Warning --> sizeof(): Parameter must be an array or an object that implements Countable /home4/dhcoder9/myschool.dhcoder.com/application/models/Crud.php 1241
[MySchool] - 2021-10-15 22:57:30 --> Query error: Unknown column 'running_year' in 'where clause' - Invalid query: SELECT *
FROM `online_exam`
WHERE `running_year` = '2021'
AND `class_id` = '3'
AND `section_id` = '1'
AND `subject_id` = '2'
AND `status` = 'published'
[MySchool] - 2021-10-15 23:00:29 --> Query error: Unknown column 'running_year' in 'where clause' - Invalid query: SELECT *
FROM `online_exam`
WHERE `running_year` = '2021'
AND `class_id` = '3'
AND `section_id` = '1'
AND `subject_id` = '2'
AND `status` = 'published'
[MySchool] - 2021-10-15 23:07:40 --> 404 Page Not Found: Public/style
