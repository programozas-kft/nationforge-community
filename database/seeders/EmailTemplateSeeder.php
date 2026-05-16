<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name'        => 'Minimal',
                'description' => 'Clean, text-focused layout. No images, no distractions — just your message.',
                'category'    => 'minimal',
                'is_system'   => true,
                'body_html'   => $this->minimal(),
            ],
            [
                'name'        => 'Newsletter',
                'description' => 'Branded header, main content area, and a footer with unsubscribe notice.',
                'category'    => 'newsletter',
                'is_system'   => true,
                'body_html'   => $this->newsletter(),
            ],
            [
                'name'        => 'Announcement',
                'description' => 'Bold centered headline with a call-to-action button. Great for events and news.',
                'category'    => 'announcement',
                'is_system'   => true,
                'body_html'   => $this->announcement(),
            ],
            [
                'name'        => 'Promotional',
                'description' => 'Colored header band, highlight box, and a prominent CTA button.',
                'category'    => 'promotional',
                'is_system'   => true,
                'body_html'   => $this->promotional(),
            ],
        ];

        foreach ($templates as $t) {
            EmailTemplate::firstOrCreate(['name' => $t['name'], 'is_system' => true], $t);
        }
    }

    private function minimal(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Email</title>
</head>
<body style="margin:0;padding:0;background:#f9fafb;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;color:#212529">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f9fafb;padding:32px 0">
  <tr><td align="center">
    <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:10px;border:1px solid #e9ebec;overflow:hidden">

      <!-- Header -->
      <tr><td style="padding:28px 40px 20px;border-bottom:1px solid #f0f0f5">
        <p style="margin:0;font-size:0.9rem;font-weight:700;color:#405189">Your Organization</p>
      </td></tr>

      <!-- Body -->
      <tr><td style="padding:32px 40px">
        <h1 style="margin:0 0 16px;font-size:1.5rem;font-weight:700;color:#212529;line-height:1.3">
          Email headline here
        </h1>
        <p style="margin:0 0 16px;font-size:0.9375rem;color:#495057;line-height:1.7">
          Start writing your message. This template keeps things simple and readable.
          Replace this text with your actual content.
        </p>
        <p style="margin:0 0 16px;font-size:0.9375rem;color:#495057;line-height:1.7">
          Add more paragraphs as needed. Keep it concise and focused on a single message.
        </p>
        <p style="margin:24px 0 0;font-size:0.875rem;color:#6c757d">
          Best regards,<br>
          <strong>Your Organization</strong>
        </p>
      </td></tr>

      <!-- Footer -->
      <tr><td style="padding:20px 40px;background:#f8f9fa;border-top:1px solid #e9ebec">
        <p style="margin:0;font-size:0.75rem;color:#adb5bd;text-align:center">
          You received this email because you subscribed to our newsletter.<br>
          <a href="#" style="color:#adb5bd">Unsubscribe</a>
        </p>
      </td></tr>

    </table>
  </td></tr>
</table>
</body>
</html>
HTML;
    }

    private function newsletter(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Newsletter</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f8;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;color:#212529">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f8;padding:32px 0">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="border-radius:12px;overflow:hidden">

      <!-- Header band -->
      <tr><td style="background:#0b1437;padding:24px 40px;text-align:center">
        <p style="margin:0;font-size:1.1rem;font-weight:800;color:#ffffff;letter-spacing:.02em">YOUR ORGANIZATION</p>
        <p style="margin:4px 0 0;font-size:0.8rem;color:#8ba3d4">Monthly Newsletter</p>
      </td></tr>

      <!-- Hero -->
      <tr><td style="background:#ffffff;padding:36px 40px 28px">
        <h1 style="margin:0 0 12px;font-size:1.625rem;font-weight:700;color:#212529;line-height:1.3">
          Newsletter Headline
        </h1>
        <p style="margin:0;font-size:0.9375rem;color:#495057;line-height:1.7">
          Introductory paragraph. Summarize the main theme of this newsletter in 2-3 sentences.
          What is the most important thing your readers should know?
        </p>
      </td></tr>

      <!-- Divider -->
      <tr><td style="background:#ffffff;padding:0 40px"><hr style="border:none;border-top:1px solid #f0f0f5;margin:0"></td></tr>

      <!-- Section -->
      <tr><td style="background:#ffffff;padding:28px 40px">
        <h2 style="margin:0 0 10px;font-size:1.1rem;font-weight:600;color:#343a40">Main Story</h2>
        <p style="margin:0 0 14px;font-size:0.9rem;color:#495057;line-height:1.7">
          Main content goes here. Tell your story, share news, or explain an initiative.
          Keep paragraphs short for readability.
        </p>
        <p style="margin:0;font-size:0.9rem;color:#495057;line-height:1.7">
          Second paragraph with additional details.
        </p>
      </td></tr>

      <!-- Two highlights -->
      <tr><td style="background:#f8f9fa;padding:20px 40px">
        <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td width="48%" style="background:#fff;border-radius:8px;border:1px solid #e9ebec;padding:16px 18px">
              <p style="margin:0 0 6px;font-size:0.8rem;font-weight:600;color:#405189;text-transform:uppercase;letter-spacing:.06em">Highlight 1</p>
              <p style="margin:0;font-size:0.875rem;color:#495057;line-height:1.6">Short description of this highlight or event.</p>
            </td>
            <td width="4%"></td>
            <td width="48%" style="background:#fff;border-radius:8px;border:1px solid #e9ebec;padding:16px 18px">
              <p style="margin:0 0 6px;font-size:0.8rem;font-weight:600;color:#0ab39c;text-transform:uppercase;letter-spacing:.06em">Highlight 2</p>
              <p style="margin:0;font-size:0.875rem;color:#495057;line-height:1.6">Short description of this highlight or event.</p>
            </td>
          </tr>
        </table>
      </td></tr>

      <!-- Sign-off -->
      <tr><td style="background:#ffffff;padding:28px 40px 36px">
        <p style="margin:0;font-size:0.9rem;color:#495057;line-height:1.7">
          Thank you for your continued support!<br><br>
          Warm regards,<br>
          <strong>The Team</strong>
        </p>
      </td></tr>

      <!-- Footer -->
      <tr><td style="background:#0b1437;padding:18px 40px">
        <p style="margin:0;font-size:0.72rem;color:#8ba3d4;text-align:center">
          © 2026 Your Organization &nbsp;|&nbsp;
          <a href="#" style="color:#8ba3d4;text-decoration:underline">Unsubscribe</a>
        </p>
      </td></tr>

    </table>
  </td></tr>
</table>
</body>
</html>
HTML;
    }

    private function announcement(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Announcement</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f8;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;color:#212529">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f8;padding:40px 0">
  <tr><td align="center">
    <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:14px;border:1px solid #e9ebec;overflow:hidden">

      <!-- Top accent bar -->
      <tr><td style="background:linear-gradient(135deg,#405189,#7a5af8);height:5px;line-height:5px;font-size:5px">&nbsp;</td></tr>

      <!-- Logo area -->
      <tr><td style="padding:28px 40px 0;text-align:center">
        <p style="margin:0;font-size:0.85rem;font-weight:700;color:#405189;letter-spacing:.04em;text-transform:uppercase">
          Your Organization
        </p>
      </td></tr>

      <!-- Centered heading -->
      <tr><td style="padding:24px 48px 20px;text-align:center">
        <h1 style="margin:0 0 14px;font-size:2rem;font-weight:800;color:#212529;line-height:1.25">
          Big Announcement Title
        </h1>
        <p style="margin:0;font-size:1rem;color:#6c757d;line-height:1.6">
          A short subtitle that provides context and builds excitement.
        </p>
      </td></tr>

      <!-- Divider -->
      <tr><td style="padding:0 48px"><hr style="border:none;border-top:2px dashed #f0f0f5;margin:0"></td></tr>

      <!-- Content -->
      <tr><td style="padding:24px 48px">
        <p style="margin:0 0 16px;font-size:0.9375rem;color:#495057;line-height:1.7;text-align:center">
          Explain the announcement in 2-3 sentences. What is happening, when, and why it matters
          to your audience.
        </p>
        <p style="margin:0;font-size:0.9375rem;color:#495057;line-height:1.7;text-align:center">
          Additional detail or call to action text goes here.
        </p>
      </td></tr>

      <!-- CTA Button -->
      <tr><td style="padding:8px 48px 36px;text-align:center">
        <a href="#" style="display:inline-block;padding:14px 36px;background:#405189;color:#ffffff;font-size:0.9375rem;font-weight:700;text-decoration:none;border-radius:8px;letter-spacing:.02em">
          Learn More →
        </a>
      </td></tr>

      <!-- Footer -->
      <tr><td style="padding:20px 40px;background:#f8f9fa;border-top:1px solid #e9ebec">
        <p style="margin:0;font-size:0.72rem;color:#adb5bd;text-align:center">
          You received this because you subscribed to updates from Your Organization.<br>
          <a href="#" style="color:#adb5bd">Unsubscribe</a>
        </p>
      </td></tr>

    </table>
  </td></tr>
</table>
</body>
</html>
HTML;
    }

    private function promotional(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Promotional</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f8;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;color:#212529">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f8;padding:32px 0">
  <tr><td align="center">
    <table width="580" cellpadding="0" cellspacing="0" style="border-radius:14px;overflow:hidden">

      <!-- Colored header -->
      <tr><td style="background:linear-gradient(135deg,#0ab39c,#405189);padding:36px 40px;text-align:center">
        <p style="margin:0 0 6px;font-size:0.8rem;font-weight:600;color:rgba(255,255,255,0.7);text-transform:uppercase;letter-spacing:.08em">
          Special Offer
        </p>
        <h1 style="margin:0;font-size:1.75rem;font-weight:800;color:#ffffff;line-height:1.25">
          Exclusive Member Benefit
        </h1>
      </td></tr>

      <!-- Content -->
      <tr><td style="background:#ffffff;padding:32px 40px">
        <p style="margin:0 0 20px;font-size:0.9375rem;color:#495057;line-height:1.7">
          Dear member, we have something special for you. This is the main promotional message
          — be clear about the value you're offering.
        </p>

        <!-- Highlight box -->
        <table width="100%" cellpadding="0" cellspacing="0">
          <tr><td style="background:#f0fff8;border:1px solid #c3f0e0;border-radius:10px;padding:20px 24px;margin:0 0 24px">
            <p style="margin:0 0 6px;font-size:0.85rem;font-weight:700;color:#0ab39c;text-transform:uppercase;letter-spacing:.04em">What you get</p>
            <ul style="margin:0;padding:0 0 0 18px;color:#212529;font-size:0.9rem;line-height:1.8">
              <li>Benefit one — explain clearly</li>
              <li>Benefit two — keep it concise</li>
              <li>Benefit three — make it compelling</li>
            </ul>
          </td></tr>
        </table>

        <p style="margin:0 0 24px;font-size:0.875rem;color:#6c757d;line-height:1.6">
          Additional details, terms, or deadline information.
        </p>

        <!-- CTA Button -->
        <table width="100%" cellpadding="0" cellspacing="0">
          <tr><td align="center">
            <a href="#" style="display:inline-block;padding:15px 40px;background:#0ab39c;color:#ffffff;font-size:1rem;font-weight:700;text-decoration:none;border-radius:10px">
              Claim Your Benefit →
            </a>
          </td></tr>
        </table>
      </td></tr>

      <!-- Sign-off -->
      <tr><td style="background:#ffffff;padding:0 40px 32px">
        <p style="margin:24px 0 0;font-size:0.875rem;color:#6c757d;line-height:1.6;border-top:1px solid #f0f0f5;padding-top:20px">
          Thank you for being a valued member of our community!<br>
          <strong style="color:#212529">Your Organization</strong>
        </p>
      </td></tr>

      <!-- Footer -->
      <tr><td style="background:#f8f9fa;padding:16px 40px;border-top:1px solid #e9ebec">
        <p style="margin:0;font-size:0.72rem;color:#adb5bd;text-align:center">
          © 2026 Your Organization &nbsp;|&nbsp;
          <a href="#" style="color:#adb5bd;text-decoration:underline">Unsubscribe</a>
        </p>
      </td></tr>

    </table>
  </td></tr>
</table>
</body>
</html>
HTML;
    }
}
