function start(){
    
    var myInput = document.getElementById("inputPassword");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");


    myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
      }
    
    myInput.onkeyup = function() {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if(myInput.value.match(lowerCaseLetters)) {
          letter.classList.remove("invalid");
          letter.classList.add("valid");
        } else {
          letter.classList.remove("valid");
          letter.classList.add("invalid");
          document.getElementById("register").disabled = true;
      }
      
        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if(myInput.value.match(upperCaseLetters)) {
          capital.classList.remove("invalid");
          capital.classList.add("valid");
          document.getElementById("register").disabled = false;
        } else {
          capital.classList.remove("valid");
          capital.classList.add("invalid");
          document.getElementById("register").disabled = true;
        }
      
        // Validate numbers
        var numbers = /[0-9]/g;
        if(myInput.value.match(numbers)) {
          number.classList.remove("invalid");
          number.classList.add("valid");
          document.getElementById("register").disabled = false;
        } else {
          number.classList.remove("valid");
          number.classList.add("invalid");
          document.getElementById("register").disabled = true;
        }
      
        // Validate length
        if(myInput.value.length >= 8) {
          length.classList.remove("invalid");
          length.classList.add("valid");
          document.getElementById("register").disabled = false;
        } else {
          length.classList.remove("valid");
          length.classList.add("invalid");
          document.getElementById("register").disabled = true;
        }
      }
}