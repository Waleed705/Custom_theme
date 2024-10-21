jQuery(document).ready(function($) {
    $("#signup").click(function(e) {
        e.preventDefault();
        let fname = $("#name").val();
        let email = $("#email").val();
        let mpassword = $("#current-password").val();
        let checkbox = $("#checkbox");
    
        let nameerror = $("#name-error");
        let emailerror = $("#email-error");
        let passworderror = $("#password-error");
        let checkerror = $("#check-error");
        
        $("#name").on('input', function() {
            nameerror.text('');
        });
    
    
        $("#email").on('input', function() {
            emailerror.text('');
        });
    
        $("#current-password").on('input', function() {
            passworderror.text('');
        });
        $("#checkbox").on('change', function() {
            checkerror.text('');
        });
        if (fname === '') {
            nameerror.text('Name is required').css('color', 'red');
        }
        if (email === '') {
            emailerror.text('Email is required').css('color', 'red');
        } else {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailPattern.test(email)) {
                emailerror.text('Please enter a valid email address').css('color', 'red');
            } else {
                emailerror.text('');
            }
        }
        if (mpassword === '') {
            passworderror.text('Password is required').css('color', 'red');
        } else if (mpassword.length < 8) {
            passworderror.text('Password must be at least 8 characters long').css('color', 'red');
        } else if (!/[A-Z]/.test(mpassword)) {
            passworderror.text('Password must contain at least one uppercase letter').css('color', 'red');
        } else if (!/[a-z]/.test(mpassword)) {
            passworderror.text('Password must contain at least one lowercase letter').css('color', 'red');
        } else if (!/[0-9]/.test(mpassword)) {
            passworderror.text('Password must contain at least one number').css('color', 'red');
        } else if (!/[!@#$%^&*(),.?":{}|<>]/.test(mpassword)) {
            passworderror.text('Password must contain at least one special character (!@#$%^&* etc.)').css('color', 'red');
        } else {
            passworderror.text('');
        }
        if (!checkbox.is(':checked')) { 
            checkerror.text('You must agree to the terms and conditions').css('color', 'red');
        }
        if (nameerror.text() !== '' || emailerror.text() !== '' || passworderror.text() !== '' || checkerror.text() !== '') {
            return false;
        }
        let formData = {
            'action': 'register_user',
            'name': fname,
            'email': email,
            'password': mpassword,
            'form': 'signup',
        };
        
        $.ajax({
            url: ajax_object.ajaxurl, 
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response){
                    if (response.success) {
                        window.location.href = response.data.url;
                    } else {
                        $("#response").text(response.data.messages);
                    }
                } else {
                    $("#response").text('Invalid response from the server.');
                }
            },
            error: function(xhr) {
                    $("#response").text(xhr.statusText || 'An error occurred. Please try again.').css('color', 'red');      
            }
        });
    });
    jQuery(document).ready(function($) {
        $("#login").click(function(e) {
            e.preventDefault();
            let fname = $("#name").val();
            let password = $("#current-password").val();
            let nameError = $("#name-error");
            let passwordError = $("#password-error");
            let responseMessage = $("#response");

            nameError.text('');
            passwordError.text('');
            responseMessage.text('');
    
            
            if (fname === '') {
                nameError.text('Email is required').css('color', 'red');
                
            }
            $("#name").on('input', function() {
                $("#name-error").text('');
                $("#response").text('');
            });
        
            $("#current-password").on('input', function() {
                $("#password-error").text(''); 
                $("#response").text('');
            });
        
            if (password === '') {
                passwordError.text('Password is required').css('color', 'red');
                return;
            }

            let formData = {
                action: 'login_user',
                fname: fname,
                password: password,
            };
            $.ajax({
                url: ajax_object.ajaxurl,
                type: 'POST',
                data: formData,
                success: function(response) {

                    if (response) {
                        if (response.success) {
                            window.location.href = response.data.url;
                        } else {
                            $("#response").text(response.data);
                        }
                    } else {
                        responseMessage.text('Invalid response from the server.').css('color', 'red');
                    }
                },
                error: function(xhr) {
                    responseMessage.text(xhr.statusText || 'An error occurred. Please try again.').css('color', 'red');
                }
            });
        });
        $("#signup2").click(function(e) {
            e.preventDefault();
            window.location.href = "/registration"; 
        });
    });
});    