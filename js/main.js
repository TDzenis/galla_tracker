var ticketApp = new Vue({
  el: '#ticketApp',
  data: {
    tickets: "",
    ticket: {

    }
  },
  methods: {
    getTickets: () => {
      fetch("/getAllTickets")
        .then(response => {
          return response.json()
        })
        .then(data => {
          //assigns JSON to variable "tickets"
          ticketApp.tickets = data;
        })
        .catch(err => {
          console.log(err);
        })
    },
    saveChanges: (id) => {
      let formId = "form" + id;
      let form = document.getElementById(formId);
      const ticketName = form.getElementsByClassName("ticket_name");
      const ticketDescription = form.getElementsByClassName("ticket_description");
      const ticketDeadline = form.getElementsByClassName("ticket_deadline");
      const ticketAssignedTo = document.getElementsByClassName("ticket_assigned_to");
      const ticketStatus = document.getElementsByClassName("ticket_status");
      const ticketImportance = document.getElementsByClassName("ticket_importance");
      const ticketEstimatedTimeNeeded = document.getElementsByClassName("ticket_estimated_time_needed");
        
        fetch('/updateTicket', {
                    method: 'POST',
                    headers: {
                      'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        ticket: {
                          ticketId: id,
                          ticketName: ticketName[0].value,
                          ticketDescription: ticketDescription[0].value,
                          ticketDeadline : ticketDeadline[0].value,
                          ticketAssignedTo: ticketAssignedTo[0].value,
                          ticketStatus: ticketStatus[0].value,
                          ticketEstimatedTimeNeeded: ticketEstimatedTimeNeeded[0].value,
                          ticketImportance: ticketImportance[0].value
                        }
                    })
                }).then((res) => {
                    return res.json();
                }).then((data => {
                    console.log(data)
                }));
    }
  },
  mounted() {
    console.log('Component has been mounted!');
    this.getTickets();
  }
})