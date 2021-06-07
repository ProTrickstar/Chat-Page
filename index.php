<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-app.js"></script>

<!-- Include Firebase and App -->
<script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-database.js"></script>

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="css/style.css">

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyB7GHrDkiyIVDA1_IuiDH9KHmWxw0q9hTs",
    authDomain: "backup-1cbc2.firebaseapp.com",
    projectId: "backup-1cbc2",
    storageBucket: "backup-1cbc2.appspot.com",
    messagingSenderId: "125212159659",
    appId: "1:125212159659:web:83ae9e456c5f1d3fe511ee"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);

  var myName = prompt("Enter Your Name")

  function sendMessage() {
      var message = document.getElementById("messaage").value;

      firebase.database().ref("messages").push().set({
          "sender": myName,
          "message": message,
      });
       
      return false;
  }

  firebase.database().ref("messages").on("child_added", function (snapshot) {
    var html = "";
    html += "<li id='message-" + snapshot.key + "'>";
      //DELETE BUTTON
      if(snapshot.val().sender == myName){
          html += "<button data-id='"+ snapshot.key +"' onclick='deleteMessage(this);'>"
          ;
           html += "Delete";
          html += "</button>";
      }
     html += snapshot.val().sender + ": " + snapshot.val().message;
    html += "</li>";

    document.getElementById("messages").innerHTML += html;
});

    function deleteMessage(self) {
        var messageId = self.getAttribute("data-id");

        firebase.database().ref("messages").child(messageId).remove();
    }
        firebase.database().ref("messages").on("child_removed", function (snapshot){
            document.getElementById("message-" + snapshot.key).innerHTML = "This message has been deleted";
        });
</script>
<!-- Create A form to send message -->
<form onsubmit="return sendMessage();">
  <input id="messaage" placeholder="Enter Message" autocomplete="off">

  <input id="submit" type="submit">
  </form>

  <!-- Create A List -->
  <ul id="messages"></ul>