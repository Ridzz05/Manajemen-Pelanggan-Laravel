<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — AWBuilder</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #FFDD00;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            /* Grid pattern background */
            background-image:
                linear-gradient(rgba(0,0,0,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,0,0,0.06) 1px, transparent 1px);
            background-size: 32px 32px;
        }
        input {
            background: #fff;
            border: 2.5px solid #000;
            color: #000;
            font-size: 14px;
            font-family: 'Space Grotesk', sans-serif;
            outline: none;
            width: 100%;
            padding: 11px 14px;
            border-radius: 0;
        }
        input:focus {
            box-shadow: 4px 4px 0 #000;
        }
        input::placeholder { color: #aaa; }
    </style>
</head>
<body>
    <div style="width:100%;max-width:400px;">

        {{-- Logo block --}}
        <div style="text-align:center;margin-bottom:24px;">
            <div style="display:inline-flex;align-items:center;gap:12px;background:#000;padding:12px 24px;border:2.5px solid #000;box-shadow:5px 5px 0 rgba(0,0,0,0.3);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFDD00" style="width:28px;height:28px;">
                    <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.268a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd"/>
                </svg>
                <div style="text-align:left;">
                    <p style="color:#FFDD00;font-weight:800;font-size:18px;letter-spacing:0.04em;line-height:1;">AWBuilder</p>
                    <p style="color:#888;font-size:10px;letter-spacing:0.15em;font-family:'Space Mono',monospace;">ADMIN PANEL</p>
                </div>
            </div>
        </div>

        {{-- Login Card --}}
        <div style="background:#fff;border:3px solid #000;box-shadow:7px 7px 0 #000;">

            <div style="background:#000;padding:14px 22px;border-bottom:3px solid #000;">
                <h1 style="font-size:15px;font-weight:800;color:#FFDD00;letter-spacing:0.08em;text-transform:uppercase;font-family:'Space Mono',monospace;">— SECURE LOGIN —</h1>
            </div>

            <div style="padding:28px 24px;">
                @if($errors->any())
                    <div style="margin-bottom:20px;padding:14px;border:2.5px solid #000;background:#FF3B3B;color:#fff;font-size:13px;font-weight:600;box-shadow:3px 3px 0 #000;">
                        <ul style="list-style:none;">
                            @foreach ($errors->all() as $error)
                                <li>⚠ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:18px;">
                    @csrf

                    <div>
                        <label for="email" style="display:block;font-size:11px;font-weight:700;color:#000;margin-bottom:6px;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@example.com">
                    </div>

                    <div>
                        <label for="password" style="display:block;font-size:11px;font-weight:700;color:#000;margin-bottom:6px;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;">Password</label>
                        <input id="password" type="password" name="password" required placeholder="••••••••">
                    </div>

                    <div style="display:flex;align-items:center;gap:8px;">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                               style="width:18px;height:18px;flex-shrink:0;accent-color:#FFDD00;cursor:pointer;">
                        <label for="remember" style="font-size:13px;font-weight:600;color:#555;cursor:pointer;">Remember Me</label>
                    </div>

                    <button type="submit"
                            style="background:#FFDD00;color:#000;font-weight:800;font-size:14px;padding:13px;border:2.5px solid #000;cursor:pointer;box-shadow:4px 4px 0 #000;letter-spacing:0.06em;text-transform:uppercase;font-family:'Space Grotesk',sans-serif;transition:box-shadow 0.1s,transform 0.1s;"
                            onmouseover="this.style.boxShadow='2px 2px 0 #000';this.style.transform='translate(2px,2px)'"
                            onmouseout="this.style.boxShadow='4px 4px 0 #000';this.style.transform='translate(0,0)'">
                        SIGN IN →
                    </button>
                </form>
            </div>
        </div>

        <p style="text-align:center;margin-top:20px;font-size:11px;color:#666;font-family:'Space Mono',monospace;letter-spacing:0.05em;">AWBuilder &copy; {{ date('Y') }}</p>
    </div>
</body>
</html>
