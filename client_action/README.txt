json format
{
  id : uid(string),
  user : user_name(string),
  trigger : sensor_name(string),
  operator : operator(string),
  value : sensor_value(string),
  actuator : actuator_name(string),
  action : action(string),
  shared : share or not(boolean),
  sharedUsers : shared user list(string)
}

ex)

+----+------+---------+----------+----------------+----------+---------+--------+------------+
| id | user | trigger | operator | value          | actuator | action  | shared | shareUsers |
+----+------+---------+----------+----------------+----------+---------+--------+------------+
|  3 | ajh  | CDS     | <        | 12             | LED3     | on      |      1 | ;cks;      |
+----+------+---------+----------+----------------+----------+---------+--------+------------+
