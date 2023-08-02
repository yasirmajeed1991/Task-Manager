<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loan Assignment</title>
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
                    New Loan Assignment
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

                    I hope this email finds you well. I am writing to inform you that a
                    new loan has been assigned to you. As the coordinator, we trust that
                    you will handle this assignment with the utmost care and professionalism.<br /><br />

                    The details for the new loan are as follows:<br /><br />

                    <strong>Loan No#:</strong> {{loan_no}}<br /><br />
                    
                    Please review the loan application and contact the borrower within
                    the next 24 hours to discuss the loan terms and requirements. You
                    will be responsible for collecting all necessary documents and
                    verifying the borrower information before submitting the loan for
                    processing.<br /><br />

                    We trust that you will keep us informed of any updates or issues
                    that arise during the loan process. If you have any questions or
                    concerns, please do not hesitate to contact me or your supervisor
                    for guidance.<br /><br />

                    Thank you for your hard work and dedication to providing our
                    clients with exceptional service.<br /><br />

                    Best regards,<br />
                   {{processor_name}}<br />
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
