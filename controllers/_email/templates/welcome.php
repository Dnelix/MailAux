<html lang="en" >
    <head>
    <title>{$c_description}</title>
        <!--[if !mso]><!-- -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--<![endif]-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
        <!--link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" type="text/css">
        <style type="text/css">
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap');
        </style-->

        <style type="text/css">
            html,body {
                padding:0;
                margin:0;
                font-family: Inter, Helvetica, "sans-serif";                                       
            }            
            a{
                text-decoration: none;
            }
			a:hover {
                color: #009ef7;
            }
            .separator {
                display: block;
                height: 0;
                border-bottom: 1px solid #F1F1F2;
            }
            .separator.separator-dashed {
                border-bottom-style: dashed;
                border-bottom-color: #DBDFE9;
            }

            @media only screen and (max-width:480px) {
                @-ms-viewport {
                    width: 320px;
                }
                @viewport {
                    width: 320px;
                }
            }

            @media only screen and (max-width:595px) {
                .container {
                    width: 100% !important;
                }
                .button {
                    display: block !important;
                    width: auto !important;
                }
            }
        </style>

    </head>
    <body style="background: {$color_sec};">
        <div style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:50px 0px 50px 0px; padding:0; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>                      
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 15px 34px 15px">
                                    <div style="margin-bottom: 10px">
                                        <a href="{$c_website}" rel="noopener" target="_blank">
                                            <img alt="Logo" src="{$logo_image}" style="max-width:80%; height: 35px"/>                
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Image" src="{$email_image}" style="max-width:100%;"/>
                                    </div>
                                    <div style="font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Hey {$to_name}, thanks for signing up!</p>
                                        <p style="margin-bottom:2px; color:#7E8299">{$message}</p>  
                                        <p style="margin-bottom:2px; color:#7E8299">Click the button below to complete your account activation and login:</p>  
                                    </div>
                                    <a href='{$activation_link}' target="_blank" style="background-color:{$color_pri}; border-radius:6px; display:inline-block; padding:11px 19px; color:#FFFFFF; font-size:14px; font-weight:500;">
                                        Activate Account
                                    </a>
                                </div>
                            </td>
                        </tr>  

                        <tr style="display: flex; justify-content: center; margin:0 60px 35px 60px">
                            <td align="start" valign="start" style="padding-bottom: 10px;">
                                <p style="color:#181C32; font-size: 18px; font-weight: 600; margin-bottom:13px">What's next?</p>
                                <span style="margin-bottom:2px; color:#7E8299; font-size: 14px;">Try any of the options below if you need some help to get started:</span>  

                                <div style="background: #F9F9F9; border-radius: 12px; padding:35px 30px">
                                    <div style="display:flex">
                                        <div style="display: flex; justify-content: center; align-items: center; width:40px; height:40px; margin-right:13px">
                                            <img alt="Logo" src="{$email_assets}icon-polygon.png"/>  
                                            <span style="position: absolute; color:{$color_pri}; font-size: 16px; font-weight: 600;"> 1 </span>
                                        </div>
                                        <div>
                                            <div>
                                                <a href="{$c_website}">
                                                    <span style="text-decoration:none; color:{$color_pri}; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">Login to your dashboard</span>
                                                    <p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif">This is where the magic happens. Login with your username and password and start adding your customers immediately.</p>
                                                </a>
                                            </div>
                                            <div class="separator separator-dashed" style="margin:17px 0 15px 0"></div>                   
                                        </div>
                                    </div>

                                    <div style="display:flex">
                                        <div style="display: flex; justify-content: center; align-items: center; width:40px; height:40px; margin-right:13px">
                                            <img alt="Logo" src="{$email_assets}icon-polygon.png"/>
                                            <span style="position: absolute; color:{$color_pri}; font-size: 16px; font-weight: 600;"> 2 </span>
                                        </div>
                                        <div>
                                            <div>
                                                <a href="{$c_website}">
                                                    <span style="text-decoration:none; color:{$color_pri}; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">How it works</span>
                                                    <p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif">Not sure how it works? Watch this brief video we have created just for you. It's really the easiest platform you have used.</p>
                                                </a>
                                            </div>
                                            <div class="separator separator-dashed" style="margin:17px 0 15px 0"></div>        
                                        </div>  
                                    </div>

                                    <div style="display:flex">
                                        <div style="display: flex; justify-content: center; align-items: center; width:40px; height:40px; margin-right:13px">
                                            <img alt="Logo" src="{$email_assets}icon-polygon.png"/>  
                                            <span style="position: absolute; color:{$color_pri}; font-size: 16px; font-weight: 600;"> 3 </span>                   
                                        </div>
                                        <div>
                                            <div>
                                                <a href="{$privacypolicy_link}">
                                                    <span style="text-decoration:none; color:{$color_pri}; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">Our Privacy Policy</span>
                                                    <p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif">We take your data and that of your customers very seriously. We will never reveal your data to anyone for any reason.</p>
                                                </a>
                                            </div>                      
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>    
                        
                        <tr>
                            <td><div class="separator separator-dashed" style="margin:17px 0 15px 0"></div></td>
                        </tr>

                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                                <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px">It's all about you!</p>
                                <p style="margin-bottom:2px">Call our customer care number: {$c_phone}</p>
                                <p style="margin-bottom:4px">You may also reach us at <a href="mailto:{$c_email}" rel="noopener" target="_blank" style="font-weight: 600">{$c_email}</a>.</p>
                                <p>We're available Mon-Fri, 9AM-5PM</p>                                
                            </td>
                        </tr>   
                        
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 20px;">                                
                                <a href="{$c_linkedin}" style="margin-right:10px"><img alt="Logo" src="{$email_assets}icon-linkedin.png"/></a>    
                                <a href="{$c_whatsapp}" style="margin-right:10px"><img alt="Logo" src="{$email_assets}icon-dribbble.png"/></a>    
                                <a href="{$c_facebook}" style="margin-right:10px"><img alt="Logo" src="{$email_assets}icon-facebook.png"/></a>   
                                <a href="{$c_twitter}"><img alt="Logo" src="{$email_assets}icon-twitter.png"/></a>                           
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="center" valign="center" style="font-size:13px; padding:0 15px; text-align:center; font-weight:500; font-family:Arial,Helvetica,sans-serif">                            
                                <p> &copy; Copyright <a href="{$c_website}" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"> {$c_shortsite}</a> {$year}.
                                </p>                         
                            </td>
                        </tr>      
                    </tbody>   
                </table> 
            </div>
        </div>
    </body>
</html>