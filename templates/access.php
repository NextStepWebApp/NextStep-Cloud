<?php
if (!defined("SECURE_ACCESS")) {
    exit('Direct access not permitted');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NextStep — <?php echo htmlspecialchars($mail_subject); ?></title>
</head>
<body style="margin:0;padding:0;background-color:#f3f6fb;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f3f6fb;padding:30px 15px;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" border="0" 
            style="max-width:600px;width:100%;background:#ffffff;border-radius:12px;overflow:hidden;table-layout:fixed;">

                <!-- Header -->
                <tr>
                    <td align="center" style="background:#1e3a8a;padding:40px 30px;">
                        <div style="font-size:42px;font-weight:800;color:#ffffff;font-family:Arial,sans-serif;margin-bottom:10px;">
                            NextStep
                        </div>
                        <div style="font-size:16px;color:#dbeafe;font-family:Arial,sans-serif;">
                            Cloud
                        </div>
                    </td>
                </tr>

                <!-- Subject banner -->
                <tr>
                    <td style="background:#eff6ff;border-bottom:1px solid #bfdbfe;padding:16px 30px;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="font-family:Arial,sans-serif;font-size:13px;color:#64748b;">
                                    MESSAGE FROM
                                </td>
                            </tr>
                            <tr>
                                <td style="font-family:Arial,sans-serif;font-size:18px;font-weight:700;color:#1e3a8a;padding-top:4px;">
                                    <?php echo htmlspecialchars($smtp_username); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Body message -->
                <tr>
                    <td style="padding:30px;">
                        <h1 style="margin:0 0 20px 0;color:#0f172a;font-size:24px;font-family:Arial,sans-serif;">
                            <?php echo htmlspecialchars($mail_subject); ?>
                        </h1>
                        <div style="margin:0;color:#334155;font-size:15px;line-height:1.7;font-family:Arial,sans-serif;">
                            <?php echo $mail_body; ?>
                        </div>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:25px;text-align:center;">
                        <p style="margin:0 0 15px 0;color:#64748b;font-size:13px;line-height:1.5;font-family:Arial,sans-serif;">
                            This email was sent to you by <?php echo htmlspecialchars($smtp_username); ?>
                            via NextStep Cloud.
                            If you believe this was sent in error, please disregard it.
                        </p>
                        <p style="margin:0;font-family:Arial,sans-serif;">
                            <a href="https://github.com/NextStepWebApp/NextStep-Cloud" style="color:#2563eb;text-decoration:none;font-weight:bold;">GitHub</a>
                            &nbsp;|&nbsp;
                            <a href="https://www.youtube.com/@MelchizedekShah" style="color:#2563eb;text-decoration:none;font-weight:bold;">YouTube</a>
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>