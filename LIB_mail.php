<?php
/*
########################################################################                                        
Copyright 2007, Michael Schrenk                                                                                 
   This software is designed for use with the book,                                                             
   "Webbots, Spiders, and Screen Scarpers", Michael Schrenk, 2007 No Starch Press, San Francisco CA             
                                                                                                                
W3C® SOFTWARE NOTICE AND LICENSE                                                                                
                                                                                                                
This work (and included software, documentation such as READMEs, or other                                       
related items) is being provided by the copyright holders under the following license.                          
 By obtaining, using and/or copying this work, you (the licensee) agree that you have read,                     
 understood, and will comply with the following terms and conditions.                                           
                                                                                                                
Permission to copy, modify, and distribute this software and its documentation, with or                         
without modification, for any purpose and without fee or royalty is hereby granted, provided                    
that you include the following on ALL copies of the software and documentation or portions thereof,             
including modifications:                                                                                        
   1. The full text of this NOTICE in a location viewable to users of the redistributed                         
      or derivative work.                                                                                       
   2. Any pre-existing intellectual property disclaimers, notices, or terms and conditions.                     
      If none exist, the W3C Software Short Notice should be included (hypertext is preferred,                  
      text is permitted) within the body of any redistributed or derivative code.                               
   3. Notice of any changes or modifications to the files, including the date changes were made.                
      (We recommend you provide URIs to the location from which the code is derived.)                           
                                                                                                                
THIS SOFTWARE AND DOCUMENTATION IS PROVIDED "AS IS," AND COPYRIGHT HOLDERS MAKE NO REPRESENTATIONS OR           
WARRANTIES, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY OR FITNESS          
FOR ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SOFTWARE OR DOCUMENTATION WILL NOT INFRINGE ANY THIRD         
PARTY PATENTS, COPYRIGHTS, TRADEMARKS OR OTHER RIGHTS.                                                          
                                                                                                                
COPYRIGHT HOLDERS WILL NOT BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL OR CONSEQUENTIAL DAMAGES ARISING OUT     
OF ANY USE OF THE SOFTWARE OR DOCUMENTATION.                                                                    
                                                                                                                
The name and trademarks of copyright holders may NOT be used in advertising or publicity pertaining to the      
software without specific, written prior permission. Title to copyright in this software and any associated     
documentation will at all times remain with copyright holders.                                                  
########################################################################                                        
*/

##################################################################
# LIB_mail.php                                                                          
# An wrapper for PHP's built-in mail() function.                                       
#-----------------------------------------------------------------                      
#formatted_mail($subject, $message, $address, $content_type)                            
#                                                                                       
#    Sends an HTML or text formatted email message though the function                  
#    formatted_mail().                                                                  
#                                                                                       
#    INPUTS:                                                                            
#     $subject     A string used as the email's subject line                            
#                                                                                       
#     $message     A string which is the body of the email                              
#                                                                                       
#     $address     An array of addresses used by the email                              
#                   $address['to']       address of the recipient                       
#                   $address['from']     address of the sender                          
#                   $address['replyto']  address where replies are sent                 
#                   $address['cc']       address of person copied on the message        
#                   $address['bcc']      like cc, but address is not disclosed          
#                                                                                       
#    $content_type Defines the mime type typical values are:                            
#                    "Text/plain"                                                       
#                    "Text/html"                                                        
#-----------------------------------------------------------------
function formatted_mail($subject, $message, $address, $content_type)
	{
   	# Set defaults
	if(!isset($address['cc']))       
        $address['cc'] = "";
	if(!isset($address['bcc']))      
        $address['bcc'] = "";
    
    # Configuring the "Reply-To:" is important because this address is also used
    # as the address where undeliverable email messages are sent. If not
    # defined, undeliverable email messages will bounce back to your system admin
    # and you won't know that an email wasn't delivered.
	if(!isset($address['replyto']))  
        $address['replyto'] = $address['from'];
    
   	# Create mail headers
	$headers = "";
	$headers = $headers . "From: ".$address['from']."\r\n";
	$headers = $headers . "Return-Path: ".$address['from']."\r\n";
	$headers = $headers . "Reply-To: ".$address['replyto']."\r\n";
    
	# Add Cc to header if needed
	if (strlen($address['cc'])< 0 )
        $headers = $headers . "Cc: ".$address['cc']."\r\n";

	# Add Bcc to header if needed
	if (strlen($address['bcc'])< 0 )
        $headers = $headers . "Bcc: ".$address['bcc']."\r\n";
	
	# Add content type
	$headers = $headers . "Content-Type: ".$content_type."\r\n";
    
	# Send the email
	$result = mail($address['to'], $subject, $message, $headers);
    
	return $result;
	}
?>
