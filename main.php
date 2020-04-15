<?php

// Initialize the session
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <!-- development version, includes helpful console warnings -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <style>
    .card {
      display: inline-flex;
      min-width: 300px;
      max-width: calc(20% - 10px);
      max-height: 300px;
      min-height: 300px;
      margin: 5px 5px 5px 5px;
    }

    .card-body {
      overflow: hidden;
    }
  </style>
</head>

<body>
  <div id="ticketApp">

    <div v-for="ticket in tickets" class="card" :id="'ticket'+ticket.id">
      <div class="card-header">{{ ticket.name }}</div>
      <div class="card-body">{{ ticket.description }}</div>
      <div class="card-footer">
        <button type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#modal'+ticket.id">Edit</button>
      </div>

      <!-- The Modal -->
      <div class="modal" :id="'modal'+ticket.id">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">{{ ticket.name }}</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <form class="form-horizontal">
                <fieldset>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="textinput">Ticket name</label>
                    <div class="col-md-12">
                      <input id="textinput" name="textinput" type="text" placeholder="not set" class="form-control input-md" :value="ticket.name">
                    </div>
                  </div>

                  <!-- Textarea -->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="textarea">Ticket description</label>
                    <div class="col-md-12">
                      <textarea class="form-control" id="textarea" name="textarea" style="height:200px;">{{ ticket.description }}</textarea>
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="textinput">Created on:</label>
                    <div class="col-md-12">
                      <input id="textinput" name="textinput" type="text" placeholder="not set" class="form-control input-md" :value="ticket.created_on">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="textinput">Completed on</label>
                    <div class="col-md-12">
                      <input id="textinput" name="textinput" type="text" placeholder="not set" class="form-control input-md" :value="ticket.completed_on">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="textinput">Deadline:</label>
                    <div class="col-md-12">
                      <input id="textinput" name="textinput" type="text" placeholder="not set" class="form-control input-md" :value="ticket.deadline">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="textinput">Completed by:</label>
                    <div class="col-md-12">
                      <input id="textinput" name="textinput" type="text" placeholder="not set" class="form-control input-md" :value="ticket.completed_by">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="textinput">Created by:</label>
                    <div class="col-md-12">
                      <input id="textinput" name="textinput" type="text" placeholder="not set" class="form-control input-md" :value="ticket.created_by">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="textinput">Assigned to:</label>
                    <div class="col-md-12">
                      <input id="textinput" name="textinput" type="text" placeholder="not set" class="form-control input-md" :value="ticket.assigned_to">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="textinput">Status:</label>
                    <div class="col-md-12">
                      <input id="textinput" name="textinput" type="text" placeholder="not set" class="form-control input-md" :value="ticket.status">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="textinput">Importance:</label>
                    <div class="col-md-12">
                      <input id="textinput" name="textinput" type="text" placeholder="not set" class="form-control input-md" :value="ticket.importance">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="textinput">Project ID:</label>
                    <div class="col-md-12">
                      <input id="textinput" name="textinput" type="text" placeholder="not set" class="form-control input-md" :value="ticket.project_id">
                    </div>
                  </div>

                  <!-- Text input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="textinput">Estimated time needed:</label>
                    <div class="col-md-12">
                      <input id="textinput" name="textinput" type="text" placeholder="not set" class="form-control input-md" :value="ticket.estimated_time_needed">
                    </div>
                  </div>

                  <!-- Button (Double) -->
                  <div class="form-group">
                    <div class="col-md-12">
                      <button id="button1id" name="button1id" class="btn btn-success" onclick="saveChanges()">Save</button>
                      <button id="button2id" name="button2id" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script src="js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>