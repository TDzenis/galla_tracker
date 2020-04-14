<?php

class User
{
  public $id;
  public $name;
  public $last_name;
  public $email;
  public $password;
  public $permission_level;
  public $company_id;
  public $project_id;
  public $ticket_id;
}

class Project
{
  public $id;
  public $name;
  public $description;
  public $ticket_id;
  public $company_id;
  public $created_by;
  public $status;
  public $created_on;
  public $finished_on;
  public $deadline;
}

class Company
{
  public $name;
  public $admin;
  public $employees_id;
  public $project_id;
  public $created_on;
}

class Ticket
{
  public $id;
  public $name;
  public $description;
  public $img;
  public $created_on;
  public $created_by;
  public $assigned_to;
  public $completed_on;
  public $completed_by;
  public $estimated_time_needed;
  public $deadline;
  public $status;
  public $importance;
  public $project_id;
}

?>