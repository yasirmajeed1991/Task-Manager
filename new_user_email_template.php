<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Registraiton</title>
</head>

<body>
    <table cellpadding="0" cellspacing="0" border="0" align="center" width="600" style="border-collapse: collapse">
        <!-- <tr>
            <td>
                <img src="[Your Company Logo URL]" alt="[Your Company Name]" width="150"
                    style="display: block; margin: 0 auto; padding-top: 20px" />
            </td>
        </tr> -->
        <tr>
            <td>
                <p style="
              font-family: Arial, sans-serif;
              font-size: 20px;
              font-weight: bold;
              color: #333333;
              text-align: center;
              padding-top: 20px;
            ">
                    Registration Successfull
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="
              font-family: Arial, sans-serif;
              font-size: 16px;
              color: #333333;
              text-align: justify;
              padding: 20px;
            ">
                    Dear {{full_name}},<br /><br />

                    We are pleased to inform you that your registration on our platform is now complete.
                    You can now log in to your account using the following credentials:<br />

                <ul style="
              font-family: Arial, sans-serif;
              font-size: 16px;
              color: #333333;
              text-align: justify;
              padding: 20px;"> 
                    <li>Email Address: {{user_email}}</li>
                    <li>Password: {{user_password}}</li>
                </ul>
                
                </p>
               <p style="
              font-family: Arial, sans-serif;
              font-size: 16px;
              color: #333333;
              text-align: justify;
              padding: 20px;"> We recommend that you log in to your account as soon as possible and update your password to something more secure.
                If you have any questions or concerns, please don't hesitate to contact our support team.<br /><br />

                Best regards,<br />
                Berger Group
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <hr style="border: none; height: 1px; background-color: #cccccc" />
                <p style="
              font-family: Arial, sans-serif;
              font-size: 12px;
              color: #999999;
              text-align: center;
              padding-bottom: 20px;
            ">
                    This email was sent by Berger Group, a subsidiary of Berger Group.
                    &copy; {{date}} Berger Group. All rights reserved.
                </p>
            </td>
        </tr>
    </table>
</body>

</html>