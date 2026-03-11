<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — AWBuilder</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                },
            },
        }
    </script>
    
    <style>
        :root {
            --bg-page: #000000;
            --bg-surface: #0a0a0a;
            --bg-input: #111111;
            --border: #1a1a1a;
            --border-mid: #2a2a2a;
            --text-primary: #ffffff;
            --text-muted: #555555;
            --text-on-primary: #000000;
            --bg-primary: #ffffff;
        }

        html, body {
            background-color: var(--bg-page);
            color: var(--text-primary);
        }

        input {
            background: var(--bg-input);
            border: 1px solid var(--border-mid);
            color: var(--text-primary);
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s;
        }

        input:focus {
            border-color: var(--text-primary);
        }

        input::placeholder {
            color: var(--text-muted);
        }

        .btn-primary {
            background: var(--bg-primary);
            color: var(--text-on-primary);
            font-weight: 600;
            font-size: 13px;
            padding: 10px 18px;
            border: none;
            cursor: pointer;
            transition: opacity 0.15s;
            width: 100%;
        }

        .btn-primary:hover {
            opacity: 0.85;
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4">
    <div style="width: 100%; max-width: 360px;">
        <div style="text-align: center; margin-bottom: 32px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 40px; height: 40px; color: var(--text-primary); margin: 0 auto 16px;">
                <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.268a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd"/>
            </svg>
            <h1 style="font-size: 18px; font-weight: 700; letter-spacing: 0.05em; line-height: 1;">AWBuilder Admin</h1>
            <p style="font-size: 11px; color: var(--text-muted); letter-spacing: 0.1em; margin-top: 4px; font-family: 'JetBrains Mono', monospace;">SECURE LOGIN</p>
        </div>

        <div style="background: var(--bg-surface); border: 1px solid var(--border); padding: 24px;">
            @if($errors->any())
                <div style="margin-bottom: 20px; padding: 12px; border: 1px solid #330000; background: #1a0000; color: #ff6b6b; font-size: 12px;">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 16px;">
                @csrf
                <div>
                    <label for="email" style="display: block; font-size: 11px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.05em; text-transform: uppercase;">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@example.com" style="width: 100%; padding: 10px 12px;">
                </div>

                <div>
                    <label for="password" style="display: block; font-size: 11px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.05em; text-transform: uppercase;">Password</label>
                    <input id="password" type="password" name="password" required placeholder="••••••••" style="width: 100%; padding: 10px 12px;">
                </div>

                <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="width: auto; margin: 0;">
                    <label class="form-check-label" for="remember" style="font-size: 11px; color: var(--text-muted);">
                        Remember Me
                    </label>
                </div>

                <div style="margin-top: 8px;">
                    <button type="submit" class="btn-primary">
                        SIGN IN
                    </button>
                </div>
            </form>
        </div>
        
        <div style="text-align: center; margin-top: 32px;">
            <p style="font-size: 10px; color: var(--text-muted); letter-spacing: 0.05em; font-family: 'JetBrains Mono', monospace;">
                AWBuilder &copy; {{ date('Y') }}
            </p>
        </div>
    </div>
</body>
</html>
