<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>HDCMS Email Design</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;background: #141422">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 10px 0 30px 0;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style=" border-collapse: collapse;">
                <tr>
                    <td align="center" bgcolor="#141422" style="padding: 40px 0 30px 0; color: #1B9388; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                        {{$title}}
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#262633" style="padding: 40px 30px 40px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color:#CFCFD1; font-family: Arial, sans-serif; font-size: 24px;font-weight: normal;">
                                    <b></b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 30px 0 30px 0; color:#CFCFD1; font-family: Arial, sans-serif; font-size: 16px; line-height: 2em;font-weight: normal;">
                                    {{$content}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                                    &reg; {{v('site.info.name')}} {{date(Y)}}<br/>
                                    <a href="#" style="color: #ffffff;">
                                        <font color="#ffffff">{{root_url()}}</font>
                                    </a>
                                </td>
                                <td align="right" width="25%">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;"></td>
                                            <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                            <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: normal;color: #262633;"> 后盾人提供技术支持</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>