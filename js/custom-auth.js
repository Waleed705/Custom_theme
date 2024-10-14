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
        

        nameerror.text('');
        emailerror.text('');
        passworderror.text('');
        checkerror.text('');
    
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
        }
        if (mpassword === '') {
            passworderror.text('Password is required').css('color', 'red');
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

                if (response && typeof response === "object") {
                    if (response.success) { 
                        window.location.href = response.data.url;
                    } else if (response.success === false) { 
                        let errorMessage = typeof response.data.message === "string" ? response.data.message : JSON.stringify(response.data.message);
                        $("#response").text(errorMessage);
                    } else {
                        $("#response").text(response.message || 'Unexpected response from the server.');
                    }
                } else {
                    $("#response").text('Invalid response from the server.');
                }
            },
            error: function(xhr, status, error) {
                try {
                    let response = JSON.parse(xhr.responseText);
                    let errorMessage = typeof response.message === "string" ? response.message : JSON.stringify(response.message);
                    $("#response").text(errorMessage || 'An error occurred. Please try again.');
                } catch (e) {
                    $("#response").text(xhr.responseText || 'An unknown error occurred.');
                }
            }
        });
        
        
    });

    jQuery(document).ready(function($) {
        $("#login").click(function(e) {
            e.preventDefault();
            let email = $("#email").val();
            let password = $("#current-password").val();
            let emailError = $("#email-error");
            let passwordError = $("#password-error");
            let responseMessage = $("#response");

            emailError.text('');
            passwordError.text('');
            responseMessage.text('');
    
            
            if (email === '') {
                emailError.text('Email is required').css('color', 'red');
                return;
            }
            if (password === '') {
                passwordError.text('Password is required').css('color', 'red');
                return;
            }

            let formData = {
                action: 'login_user',
                email: email,
                password: password,
            };

            $.ajax({
                url: ajax_object.ajaxurl,
                type: 'POST',
                data: formData,
                success: function(response) {
                
                    if (response && typeof response === "object") {
                        if (response.success) {
                            window.location.href = response.data.url;
                        } else {
                            let errorMessage = response.data ? response.data : 'Unexpected response from the server.';
                            responseMessage.text(errorMessage).css('color', 'red');
                        }
                    } else {
                        responseMessage.text('Invalid response from the server.').css('color', 'red');
                    }
                },
                error: function(xhr) {
                    responseMessage.text(xhr.responseText || 'An error occurred. Please try again.').css('color', 'red');
                }
            });
        });
    

        $("#email").on('input', function() {
            $("#email-error").text('');
            $("#response").text('');
        });
    
        $("#current-password").on('input', function() {
            $("#password-error").text(''); 
            $("#response").text('');
        });
    
        $("#signup2").click(function(e) {
            e.preventDefault();
            window.location.href = "/registration"; 
        });
    });
});    