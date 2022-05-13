<!-- Jerica Smith
    INT-2850: Server-Side Web Development
    Exercise 4-2
    This program is a contact form that lets the user send an email to a specified email address. This program validates the inputs to make sure that the user puts something in each field as well as supplies a valid email address
 -->

<!DOCTYPE html>
    <html>
        <head>
            <title>Contact Me</title>
        </head>
        <body>
            <?php
            // Creating a function that takes the $data variable and checks to see if anything is typed, and if not throw the user an error message 
            // If there is content, trim() and stripslashes() cleans up the input by removing spaces and extra slashes
                function validateInput($data, $fieldName) {
                    global $errorCount;
                    
                    if(empty($data)){
                        echo ' "$fieldName" is a required field. </br> \n';
                        ++$errorCount;
                        $retval = "";
                    } else { 
                        $retval = trim($data);
                        $retval = stripslashes($retval);
                    }

                    return($retval);
                }

            // Creating a function that does the same thing as the one above, except that it is validating an email address by comparing against a regular expression pattern.
                function validateEmail($data, $fieldName){
                    global $errorCount;
                    if (empty($data)){
                        echo "'$fieldName' is a required field. </br> \n";
                        ++$errorCount;
                        $retval = "";
                    } else {
                        $retval = trim($data);
                        $retval = stripslashes($retval);

                        $pattern = "/^[\w-]+(\.[\w-]+)*@" . "[\w-]+(\.[\w-]+)*" . "(\.[[a-z]]{2,})$/i";

                        if(preg_match($pattern, $retval) == 0){
                            echo "'$fieldName' is not a valid e-mail address. </br> \n";
                            ++$errorCount;
                        } 
                    }
                    return($retval);
                }

            // Creating a function to display the form elements: Name, Email, Subject, Message, Clear Form Button, and Submit Button, and sets them to be blank
                function dispalyForm($Sender, $Email, $Subject, $Message){
                    ?>
                    <h2 style="text-align: center"> Contact Me </h2>
                    <form name="contact" action="ContactForm.php" method="post">
                        <p>Your Name: <input type="text" name="Sender" value="<?php echo $Sender; ?>" /></p>
                        <p>Your Email: <input type="text" name="Email" value="<?php echo $Email; ?>" /></p>
                        <p>Subject: <input type="text" name="Subject" value="<?php echo $Subject; ?>" /></p>
                        <p>Message </br>
                        <textarea name="Message"> <?php echo $Message; ?></textarea></p>
                        <p><input type="reset" value="Clear Form" />&nbsp;&nbsp;<input type="submit" name="Submit" value="Send Form" /></p>
                    </form>
                    <?php
                }

                $ShowForm = TRUE;
                $errorCount = 0;
                $Sender = "";
                $Email = "";
                $Subject = "";
                $Message = "";

            // Runs user input through the validation, and makes sure there are no errors by using the $errorCount variable. If there is an error
                if(isset($_POST['Submit'])){
                    $Sender = validateInput($_POST['Sender'], "Your Name");
                    $Email = validateInput($_POST['Email'], "Your Email");
                    $Subject = validateInput($_POST['Subject'],"Subject");
                    $Message = validateInput($_POST['Message'],"Message");

                    if($errorCount == 0)
                        $ShowForm = FALSE;
                    else
                        $ShowForm = TRUE;
                    }
                
                    if($ShowForm == TRUE){
                        if ($errorCount>0){
                            echo "<p>Please re-enter the form information below. </p> \n";
                            displayForm($Sender, $Email, $Subject, $Message);
                        } else {
                            $SenderAddress = "$Sender <$Email>";
                            $Headers = "From: $SenderAddress\nCC:$SenderAddress";
                            $result = mail("webdevjerica@outlook.com", $Subject, $Message, $Headers);
                            
                                if($result)
                                    echo "<p>Your message has been sent. Thank you," . $Sender . " </p>\n";
                                else
                                 echo "<p>There was an error sending your message," . $Sender . ".</p>\n";
                        }

                    }

            ?>
        </body>
    </html>