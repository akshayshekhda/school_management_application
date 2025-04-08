<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - New Announcement</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: #4f46e5;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
            color: #374151;
        }
        .announcement-title {
            font-size: 20px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 15px;
        }
        .announcement-meta {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 20px;
        }
        .announcement-content {
            background: #f9fafb;
            padding: 20px;
            border-radius: 6px;
            border-left: 4px solid #4f46e5;
            margin-bottom: 20px;
            white-space: pre-line;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background: #f9fafb;
            color: #6b7280;
            font-size: 14px;
            border-top: 1px solid #e5e7eb;
        }
        .button {
            display: inline-block;
            background: #4f46e5;
            color: #ffffff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: 500;
        }
        .button:hover {
            background: #4338ca;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        
        <div class="content">
            <div class="announcement-title">
                {{ $announcement->title }}
            </div>
            
            <div class="announcement-meta">
                Posted by: {{ $announcement->created_by->name }}
                <br>
                Date: {{ $announcement->created_at->format('F j, Y \a\t g:i A') }}
            </div>
            
            <div class="announcement-content">
                {!! nl2br(e($announcement->content)) !!}
            </div>
            
            <div style="text-align: center;">
                <a href="{{ url('/dashboard') }}" class="button">View in Dashboard</a>
            </div>
        </div>
        
        <div class="footer">
            <p>This is an automated message from {{ config('app.name') }}. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
