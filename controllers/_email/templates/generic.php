<html lang="en" >
<head>
    <title>{$c_description}</title>
    <!--[if !mso]><!-- --><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>

    <style type="text/css">
        /* keep alive */
        .email-wraper a {
        color: {$color_pri};
        word-break: break-all;
        }
        .email-wraper .link-block {
        display: block;
        }

        .email-ul {
        margin: 5px 0;
        padding: 0;
        }
        .email-ul:not(:last-child) {
        margin-bottom: 10px;
        }
        .email-ul li {
        list-style: disc;
        list-style-position: inside;
        }
        .email-ul-col2 {
        display: flex;
        flex-wrap: wrap;
        }
        .email-ul-col2 li {
        width: 50%;
        padding-right: 10px;
        }
        
        .email-success {
        border-bottom: #1ee0ac;
        }
        .email-warning {
        border-bottom: #f4bd0e;
        }
        .email-btn {
        background: #854fff;
        border-radius: 4px;
        color: #ffffff !important;
        display: inline-block;
        font-size: 13px;
        font-weight: 600;
        line-height: 44px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        padding: 0 30px;
        }
        .email-btn-sm {
        line-height: 38px;
        }
        
        
        .email-heading {
        font-size: 18px;
        color: #854fff;
        font-weight: 600;
        margin: 0;
        line-height: 1.4;
        }
        .email-heading-sm {
        font-size: 24px;
        line-height: 1.4;
        margin-bottom: 0.75rem;
        }
        .email-heading-s1 {
        font-size: 20px;
        font-weight: 400;
        color: #526484;
        }
        .email-heading-s2 {
        font-size: 16px;
        color: #526484;
        font-weight: 600;
        margin: 0;
        text-transform: uppercase;
        margin-bottom: 10px;
        }
        .email-heading-s3 {
        font-size: 18px;
        color: #854fff;
        font-weight: 400;
        margin-bottom: 8px;
        }
        .email-heading-success {
        color: #1ee0ac;
        }
        .email-heading-warning {
        color: #f4bd0e;
        }
        .email-note {
        margin: 0;
        font-size: 13px;
        line-height: 22px;
        color: #8094ae;
        }
        
        /* keep alive */
        .email-social li {
        display: inline-block;
        padding: 4px;
        }
        .email-social li a {
        display: inline-block;
        height: 30px;
        width: 30px;
        border-radius: 50%;
        background: #ffffff;
        }


        @media (max-width: 480px) {
            .email-preview-page .card {
                border-radius: 0;
                margin-left: -20px;
                margin-right: -20px;
            }
            .email-ul-col2 li {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <table class="email-wraper" style="background: #f5f6fa; font-size: 14px; line-height: 22px; font-weight: 400; color: #8094ae; width: 100%;">
        <tr>
            <td style="padding-top:2.75rem;padding-bottom:2.75rem">

                <table style="width: 100%; max-width: 620px; margin: 0 auto;">
                    <tbody>
                        <tr>
                            <td style="padding:1.5rem;text-align:center;">
                                <a href="{$c_website}"><img style="height: 40px;" src="{$logo_image}" alt="logo"></a>
                                <p style="font-size: 13px; color: {$color_pri}; padding-top: 12px;">{$c_tagline}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table style="width: 90%; max-width: 620px; margin: 0 auto; background: #ffffff; padding:0.5rem">
                    <tbody>
                        <tr>
                            <td style="padding:2.0rem">

                                <p>{message}</p>

                                <p style="margin-top:1.5rem">
                                    ----<br>
                                    Regards,<br>
                                    <strong>{$sender}</strong>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table style="width: 100%; max-width: 620px; margin: 0 auto; background-color:#efefec; padding:0.2rem">
                    <tbody>
                        <tr>
                            <td style="padding-top:1.5rem; text-align:center;">
                                <p style="font-size: 13px;">Copyright &copy; 2020 <a href="{$c_website}">{$company}</a>. All rights reserved.</p>
                                <ul class="email-social" style="display: inline-block; padding: 3px;">
                                    <li><a href="{$c_facebook}"><img style="width: 30px;" src="images/socials/facebook.png" alt="facebook"></a></li>
                                    <li><a href="{$c_twitter}"><img style="width: 30px;" src="images/socials/twitter.png" alt="twitter"></a></li>
                                    <li><a href="{$c_youtube}"><img style="width: 30px;" src="images/socials/youtube.png" alt="youtube"></a></li>
                                    <li><a href="{$c_instagram}"><img style="width: 30px;" src="images/socials/instagram.png" alt="instagram"></a></li>
                                </ul>
                                <p style="padding-bottom:1.5rem; font-size: 12px;">
                                    This email was sent to you as a registered member of <a href="{$c_website}">{$c_shortsite}</a>.
                                    <br> To update your emails preferences <a href="#">click here</a>.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </td>
        </tr>
    </table>
    
</body>
</html>