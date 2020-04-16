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
      let form_data = JSON.stringify($('form').serializeArray());
      alert(form_data);

      fetch("save_changes.php",
        {
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
          },
          method: "POST",
          body: form_data 
      })
      .then(function(res){ console.log(res + "lol1") })
      .catch(function(res){ console.log(res + "lol2") })

    }
  },
  mounted() {
    console.log('Component has been mounted!');
    this.getTickets();
  }
})