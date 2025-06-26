<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table width="100%" max-width="600px" style="background-color:#ffffff; padding:30px; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.1);">
                    <tr>
                        <td align="center" style="padding-bottom:20px;">
                            <h1 style="color:#333333;">🔐 Your OTP Code</h1>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-bottom:20px;">
                            <p style="font-size:16px; color:#555555;">Use the one-time password below to complete your verification process.</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-bottom:30px;">
                            <div style="display:inline-block; background-color:#f0f0f0; color:#333; padding:15px 30px; font-size:24px; letter-spacing:4px; border-radius:8px; font-weight:bold;">
                                {{ $otp }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <p style="font-size:14px; color:#999999;">This code will expire in <strong>1 minute</strong>.</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-top:30px;">
                            <p style="font-size:12px; color:#cccccc;">If you did not request this code, please ignore this email.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
