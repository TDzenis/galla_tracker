var ticketApp = new Vue({
  el: '#ticketApp',
  data: {
    tickets: "",
    
  },
  methods: {
    getTickets: function() {
      fetch("getalltickets.php")
        .then(response => {
          return response.json()
        })
        .then(data => {
          //assigns JSON to variable "tickets"
          ticketApp.tickets = data;
          console.log(data)
        })
        .catch(err => {
          console.log(err);
        })
    },
    saveChanges: function() {
      //TO-DO
    }
  },
  mounted() {
    console.log('Component has been mounted!');
    this.getTickets();
  }
})