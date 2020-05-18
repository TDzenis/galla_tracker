var ticketApp = new Vue({
  el: '#ticketApp',
  data: {
    tickets: ""
  },
  methods: {
    getTickets: () => {
      fetch("/getAllTickets")
        .then(response => {
          return response.json()
        })
        .then(data => {
          //assigns data from JSON to variable "tickets"
          ticketApp.tickets = data;
        })
        .catch(err => {
          console.error(err);
        })
    },
    saveChanges: (id) => {
      let formId = "form" + id;
      let form = document.getElementById(formId);
      const ticketName = form.getElementsByClassName("ticket_name");
      const ticketDescription = form.getElementsByClassName("ticket_description");
      
      const ticket = {
        ticketId: id,
        ticketName: ticketName[0].value,
        ticketDescription: ticketDescription[0].value
      }

      console.log(ticket);

        fetch('/updateTicket', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(ticket)
      }).then((res) => {
          return res.json();
      }).then((data => {
          console.log(data)
      }));
    }
  },
  mounted() {
    this.getTickets();
  }
})