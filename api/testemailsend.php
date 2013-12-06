<?php

	$to = "lonedune@gmail.com";
	$subject = "CHARM: Locked Account";
	$mainHeader = "Your account has been locked";	
	$content = "Your account at CHARM has been accessed and failed to login multiple times. Your password has been reset and you are required to click this link to reactivate your account.<br/>";
	$content.="<br/><br/><small>This is a generated email, do not reply to this email.</small>";
?>
<?php
    $message = <<<EOF

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody><tr>
        <td>
            <div align="center">
                
                <table border="0" cellpadding="0" cellspacing="0" width="592">
                    <tbody><tr>
                        <td style="font-family: Lucida Sans Unicode;color: #333;">
                        	<table border="0" cellpadding="0" cellspacing="0" width="592">
                            <tr><td><h1>$mainHeader</h1></td><td align="right"><a href="#"><img src="http://lonedune.50webs.com/nursing-home-logo.jpg" width="80" /></a></td></tr>
                            </table>
                        
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">

                                <tbody><tr>
                                    <td align="center">
                                        <table border="0" cellpadding="0" cellspacing="0" width="550">
                                            
                                            <tbody>
                                            <tr>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody><tr>
                                                            <td align="left" valign="top" width="208">
                                                            
                                                            
                                                            
                                                            </td>
                                                            <td style="padding: 0px 0px 0px 10px;" align="right" valign="top" width="322"></td>
                                                        </tr>
                                                    </tbody></table>
													
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="padding: 10px 0px 0px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>                                             
                                                <td colspan="3" align="left" width="592"><img alt="" src="http://www.cacimpresario.com/2013/images/email_imgs/email_top.gif" style="display: block;" border="0" width="592" height="5"></td>

                                            </tr>
                                            <tr>
                                                <td bgcolor="#eb9706" width="1"><img alt="" src="http://www.cacimpresario.com/2013/images/email_imgs/spacer.gif" style="display: block;" border="0" width="1" height="1"></td>
                                                <td valign="top" width="590">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td style="padding: 0px 10px 10px 10px;">
                                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                    <tbody>
                                                                    <tr>

                                                                        <td colspan="2" style="padding: 0px 0px 0px 10px;" align="left" width="550"><table border="0" bordercolor="" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><table border="0" bordercolor="" cellpadding="5" cellspacing="0" width="100%"><tbody><tr><td style="font-family: Arial; font-size: 13px;"></td></tr></tbody></table></td></tr></tbody></table></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="padding: 0px 0px 0px 10px;" align="left" width="550"><table border="0" bordercolor="" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><table border="0" bordercolor="" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="font-family: Arial; font-size: 13px;"></td></tr></tbody></table></td></tr></tbody></table></td>
                                                                    </tr>
                                                                    <tr>
                                                                        
                                                                        <td align="left" valign="top" width="355"><table border="0" bordercolor="" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><table border="0" bordercolor="" cellpadding="5" cellspacing="0" width="100%"><tbody><tr><td style="font-family: Lucida Sans Unicode; font-size: 12px;color: #333;">

<font color="#f79646" size="4">$subject</font>
<p>$content</p>
                                                                        
                                                                        </td>
                                                                    </tr></tbody></table></td></tr></tbody></table></td>

                                                                    </tr>
                                                                </tbody></table>
                                                            </td>
                                                        </tr>
                                                    </tbody></table>
                                                </td>
                                                <td bgcolor="#eb9706" width="1"><img alt="" src="http://www.cacimpresario.com/2013/images/email_imgs/spacer.gif" style="display: block;" border="0" width="1" height="1"></td>
                                            </tr>

                                            <tr>                                             
                                                <td colspan="3" align="left" width="592"><img alt="" src="http://www.cacimpresario.com/2013/images/email_imgs/email_bot.gif" style="display: block;" border="0" width="592" height="5"></td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0px;" align="left"><table border="0" bordercolor="" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td><table border="0" bordercolor="" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td>
                                    
                                    

                                    </td></tr></tbody></table></td></tr></tbody></table></td>
                                </tr>
                                <tr>
                                    <td style="padding: 0px;" align="left"></td>
                                </tr>
                                <tr>
                                    <td style="padding: 0px;" align="left"></td>
                                </tr>

                                <tr>
                                    <td style="padding: 10px 0px 0px;" align="left"><font style="font-family:Lucida Sans Unicode; font-size:10px"><p>CONFIDENTIALITY CAUTION: This message is intended only for the use of the individual(s) or entity(ies) to whom it is addressed and contains information that is privileged and confidential. If you, the reader of this message, are not the intended recipient, you should not disseminate, distribute or copy this communication. If you have received this communication in error, please notify immediately by return email and delete the original message. Thank you.</p></font></td>
                                </tr>
                            </tbody></table>

                        </td>
                    </tr>
                </tbody></table>
            </div>
        </td>
    </tr>
</tbody></table>


EOF;
   //end of message
    $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: CHARM <noreply@charm.org>' . "\r\n";
    //$headers .= 'From: noreply@cacimpresario.com <noreply@cacimpresario.com>' . "\r\n";


    //options to send to cc+bcc
    //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
    //$headers .= "Bcc: [email]email@maaking.cXom[/email]";
    
    // now lets send the email.


    
    if(mail($to, $subject, $message, $headers)){
        echo "sent";
    }
    else{
        echo "not send";
    }

    //echo $message;
?>