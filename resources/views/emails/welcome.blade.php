<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Passion2Plant</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f4f8f4; font-family: Arial, Helvetica, sans-serif; color: #333333;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0"
        style="background-color: #f4f8f4; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="max-width: 640px; background-color: #ffffff; border-radius: 10px; overflow: hidden; border: 1px solid #dfe9df;">

                    <tr>
                        <td style="background-color: #2e7d32; padding: 30px; text-align: center;">
                            <h1 style="margin: 0; font-size: 28px; color: #ffffff;">
                                Welcome to Passion2Plant
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 35px 30px;">
                            <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6;">
                                Dear {{ $data['first_name'] ?? 'Member' }},
                            </p>

                            <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6;">
                                Welcome to <strong>Passion2Plant Membership</strong>.
                            </p>

                            <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6;">
                                Your participation is deeply appreciated and makes a meaningful difference in supporting
                                the vision and mission of Passion2Plant.
                            </p>

                            <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6;">
                                We are grateful for your support and for joining this growing community. Your commitment
                                helps us continue developing resources, strengthening connections, and advancing the
                                work we believe in.
                            </p>

                            @if (!empty($data['membership_plan']))
                                <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6;">
                                    <strong>Membership Plan:</strong> {{ ucfirst($data['membership_plan']) }}
                                </p>
                            @endif

                            @if (!empty($data['provider']))
                                <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6;">
                                    <strong>Payment Provider:</strong> {{ ucfirst($data['provider']) }}
                                </p>
                            @endif

                            @if (!empty($data['subscription_id']))
                                <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.6;">
                                    <strong>Subscription ID:</strong> {{ $data['subscription_id'] }}
                                </p>
                            @endif

                            <p style="margin: 30px 0 0; font-size: 16px; line-height: 1.6;">
                                Thank you again for being part of Passion2Plant.
                            </p>

                            <p style="margin: 20px 0 0; font-size: 16px; line-height: 1.6;">
                                Blessings,<br>
                                <strong>Passion2Plant Team</strong>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="background-color: #e8f5e9; padding: 18px 30px; text-align: center; font-size: 13px; color: #4b4b4b;">
                            © {{ date('Y') }} Passion2Plant. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
