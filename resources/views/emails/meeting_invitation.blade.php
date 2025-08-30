<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Meeting</title>
</head>
<body style="font-family: Arial, sans-serif, 'Helvetica Neue', Helvetica; background-color: #f4f6f9; margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f6f9; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="650" cellpadding="0" cellspacing="0" border="0" style="background: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); max-width: 650px;">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" style="border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px;">
                            <h1 style="margin: 0; font-size: 20px; color: #1e40af; font-family: Arial, sans-serif;">LPK Amarta Bangun Indonesia Cabang Cibitung</h1>
                            <p style="margin: 5px 0 0; font-size: 14px; color: #555; font-family: Arial, sans-serif;">Undangan Rapat Virtual</p>
                        </td>
                    </tr>

                    <!-- Spacing -->
                    <tr><td height="20"></td></tr>

                    <!-- Meeting Title & Content -->
                    <tr>
                        <td>
                            <h2 style="font-size: 18px; margin: 0 0 10px; color: #333; font-family: Arial, sans-serif;">{{ $title }}</h2>
                            <div style="background: #e0f2fe; padding: 10px; border-radius: 6px; font-size: 14px; color: #0369a1; font-family: Arial, sans-serif;">
                                {{ $content }}
                            </div>
                        </td>
                    </tr>

                    <!-- Spacing -->
                    <tr><td height="20"></td></tr>

                    <!-- Meeting Details -->
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-bottom: 12px;">
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td width="30" valign="top">
                                                    <div style="width: 20px; height: 20px; background: #1e40af; border-radius: 3px; display: inline-block; text-align: center; line-height: 20px; color: white; font-size: 12px; font-weight: bold;">📅</div>
                                                </td>
                                                <td valign="top">
                                                    <strong style="display: block; font-size: 14px; color: #111; font-family: Arial, sans-serif; margin-bottom: 2px;">Tanggal</strong>
                                                    <span style="font-size: 13px; color: #444; font-family: Arial, sans-serif;">{{ \Carbon\Carbon::parse($scheduledAt)->locale('id')->translatedFormat('l, d F Y') }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td width="30" valign="top">
                                                    <div style="width: 20px; height: 20px; background: #1e40af; border-radius: 3px; display: inline-block; text-align: center; line-height: 20px; color: white; font-size: 12px; font-weight: bold;">🕒</div>
                                                </td>
                                                <td valign="top">
                                                    <strong style="display: block; font-size: 14px; color: #111; font-family: Arial, sans-serif; margin-bottom: 2px;">Waktu</strong>
                                                    <span style="font-size: 13px; color: #444; font-family: Arial, sans-serif;">{{ \Carbon\Carbon::parse($scheduledAt)->format('H:i') }} WIB</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Spacing -->
                    <tr><td height="25"></td></tr>

                    <!-- Meeting Link -->
                    <tr>
                        <td align="center">
                            <strong style="font-family: Arial, sans-serif; color: #333;">
                                {{ $platform === 'zoom' ? 'Link Zoom Meeting' : 'Link Google Meet' }}
                            </strong>
                            <br><br>

                            <a href="{{ $meetLink }}" style="display: inline-block; background: #2563eb; color: #ffffff !important; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-size: 14px; font-family: Arial, sans-serif; font-weight: bold;" target="_blank">
                                Bergabung ke Meeting
                            </a>

                            <div style="margin-top: 10px; font-size: 12px; color: #555; font-family: Arial, sans-serif; word-break: break-all; padding: 0 20px;">
                                {{ $meetLink }}
                            </div>

                            @if ($platform === 'zoom')
                                <div style="margin-top: 15px; font-size: 13px; color: #333; font-family: Arial, sans-serif;">
                                    <p style="margin: 5px 0;"><strong>Meeting ID:</strong> {{ $zoomMeetingId }}</p>
                                    <p style="margin: 5px 0;"><strong>Passcode:</strong> {{ $zoomPasscode }}</p>
                                </div>
                            @endif
                        </td>
                    </tr>


                    <!-- Spacing -->
                    <tr><td height="20"></td></tr>

                    <!-- Footer Warning -->
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #fef9c3; padding: 10px; border-radius: 6px;">
                                <tr>
                                    <td width="30" valign="top">
                                        <div style="width: 20px; height: 20px; background: #92400e; border-radius: 3px; display: inline-block; text-align: center; line-height: 20px; color: white; font-size: 12px; font-weight: bold;">⚠️</div>
                                    </td>
                                    <td valign="top" style="font-size: 13px; color: #92400e; font-family: Arial, sans-serif; line-height: 1.4;">
                                        <strong>Penting:</strong> Harap hadir tepat waktu. Terima kasih atas partisipasi Anda.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Spacing -->
                    <tr><td height="20"></td></tr>

                    <!-- Action Button -->
                    <tr>
                        <td align="center">
                            <a href="{{ $meetLink }}" style="display: inline-block; background: #16a34a; color: #ffffff !important; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-size: 14px; font-weight: bold; font-family: Arial, sans-serif;" target="_blank">
                                Bergabung Sekarang
                            </a>
                        </td>
                    </tr>

                    <!-- Spacing -->
                    <tr><td height="25"></td></tr>

                    <!-- Footer Info -->
                    <tr>
                        <td align="center" style="font-size: 11px; color: #777; font-family: Arial, sans-serif; line-height: 1.4;">
                            Undangan ini dibuat secara otomatis oleh sistem LPK Amarta Bangun Indonesia
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>