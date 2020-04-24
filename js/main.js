var ticketApp = new Vue({
  el: '#ticketApp',
  data: {
    tickets: "",
    
  },
  methods: {
    getTickets: function() {
      fetch("/getAllTickets")
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
    saveChanges: function (form) {
      console.log("form:" + form);
      console.log("------------------------");
      var form_data = $(this).serializeArray();
      console.table(form_data);
      alert(form_data);
      alert();
      
/*
      fetch("save_changes.php",
        {
          method: "post",
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(form_data) 
      })
      .then(function(res){ console.log(res + "lol1") })
      .catch(function(res){ console.log(res + "lol2") })
*/
    }
  },
  mounted() {
    console.log('Component has been mounted!');
    this.getTickets();
  }
})