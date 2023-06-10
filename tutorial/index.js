
window.onload = function () {
    document.getElementById("myForm").addEventListener("submit", function(event){
        event.preventDefault(); 

        // Get form elements
        var name = document.getElementById('name');
        var age = document.getElementById('age');
        var gender = document.getElementById('gender');
        var email = document.getElementById('email');
        var phone = document.getElementById('phone');
        var other = document.getElementById('other');

        // Validate form fields
        if(name.value === '' || age.value === '' || gender.value === '' || email.value === '' || phone.value === '' || other.value === ''){
            alert("Please fill out all fields.");
            return false;
        }

        // Validate email
        var re = /\S+@\S+\.\S+/;
        if(!re.test(email.value)) {
            alert("Please enter a valid email.");
            return false;
        }

        this.submit();
    });
}
