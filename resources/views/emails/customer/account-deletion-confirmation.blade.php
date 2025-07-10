<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirm Account Deletion</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .content { background-color: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .button { display: inline-block; background-color: #dc3545; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; margin: 20px 0; }
        .button:hover { background-color: #c82333; }
        .warning { background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 4px; padding: 15px; margin: 20px 0; }
        .footer { margin-top: 20px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Account Deletion Confirmation</h2>
    </div>

    <div class="content">
        <p>Hello {{ $user->name }},</p>

        <p>We received a request to delete your account. If you want to proceed with the deletion, please click the button below:</p>

        <div class="warning">
            <strong>⚠️ Warning:</strong> This action is irreversible. Once you confirm, your account and all associated data will be permanently deleted.
        </div>

        <div style="text-align: center;">
            <a href="{{ route('customer.account.confirm-deletion', ['token' => $token]) }}" class="button">
                Confirm Account Deletion
            </a>
        </div>

        <p>If you did not request this deletion, please ignore this email. Your account will remain active.</p>

        <p>This link will expire in 24 hours for security reasons.</p>

        <p>If you have any questions, please contact our support team.</p>

        <p>Best regards,<br>{{ config('app.name') }} Team</p>
    </div>

    <div class="footer">
        <p>This email was sent to {{ $user->email }}. If you received this email in error, please ignore it.</p>
    </div>
</body>
</html>
