//javascript file takes php JSON response if needed and formats output

$(function () {

    /*
    initiate the validator for contact form id 
    download from http://1000hz.github.io/bootstrap-validator
    */
    $('#contact-form').validator();
    
    //when the form is submitted
    $('contact-form').on('submit', function(e) {
        //if validator allows form submit
        if(!e.isDefaultPrevented()){
            var url = 'form-to-email.php';


            //POST values in the background of the script url

            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function(data){ //data is JSON object php file responds with 

                    //here we recieve the type of the message
                    var messageAlert = "alert-" + data.type; 
                    var messageText = data.message; 

                    //now to actuall format alert box in html
                    var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';

                    //if theres a type and message from the php file

                    if(messageAlert && messageText){
                        // inject the alert to .messages class on our form
                        $('#contact-form').find('.messages').html(alertBox);

                        //reset the form 
                        $('#contact-form')[0].reset();
                    }

                }
            });
            return false;
        }
    })
});