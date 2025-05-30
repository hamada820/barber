<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'kharismabarbershp@gmail.com'; // fallback (opsional)
    public string $fromName   = 'Kharisma Barbershop';         // fallback (opsional)
    public string $recipients = '';

    public string $userAgent = 'CodeIgniter';

    public string $protocol = 'smtp'; // atau bisa gunakan: env('email.protocol', 'smtp');

    public string $mailPath = '/usr/sbin/sendmail';

    public string $SMTPHost = 'smtp.gmail.com';
    public string $SMTPUser = 'kharismabarbershp@gmail.com';
    public string $SMTPPass = 'isi_dengan_app_password_gmail';
    public int    $SMTPPort = 465;

    public int  $SMTPTimeout = 10;
    public bool $SMTPKeepAlive = true;

    public string $SMTPCrypto = 'ssl';

    public bool $wordWrap = true;
    public int  $wrapChars = 76;

    public string $mailType = 'html';
    public string $charset  = 'UTF-8';

    public bool $validate = true;
    public int  $priority = 3;

    public string $CRLF    = "\r\n";
    public string $newline = "\r\n";

    public bool $BCCBatchMode  = false;
    public int  $BCCBatchSize  = 200;

    public bool $DSN = false;
}
