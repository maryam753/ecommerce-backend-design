    <style>

        body{
            background: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-container{
            width: 420px;
            background: #fff;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin: 50px auto;
        }

        .logo{
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 25px;
            color: black;
        }

        .login-title{
            font-size: 32px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 5px;
        }

        .login-subtitle{
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .input-group{
            margin-bottom: 20px;
        }

        .input-label{
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }

        .custom-input{
            width: 100%;
            padding: 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            transition: 0.3s;
        }

        .custom-input:focus{
            border-color: black;
            outline: none;
            box-shadow: 0 0 0 4px rgba(0,0,0,0.05);
        }

        .remember-box{
            display: flex;
            align-items: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .remember-box input{
            margin-right: 8px;
        }

        .remember-box span{
            font-size: 14px;
            color: #4b5563;
        }

        .login-btn{
            width: 100%;
            background: black;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-btn:hover{
            background: #222;
        }

        .bottom-links{
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .bottom-links a{
            color: black;
            text-decoration: none;
            font-weight: 600;
        }

        .error-text{
            color: red;
            font-size: 13px;
            margin-top: 5px;
        }

        .status-message{
            background: #ecfdf5;
            color: #065f46;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

    </style>

    <div class="login-container">

        <div class="logo">
           BRAND
        </div>

        <h2 class="login-title">Welcome Back</h2>

        <p class="login-subtitle">
            Login to continue your shopping journey.
        </p>

        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <label class="input-label">Email Address</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="custom-input"
                    placeholder="Enter your email"
                    required
                    autofocus
                >

                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">

                <label class="input-label">Password</label>

                <input
                    type="password"
                    name="password"
                    class="custom-input"
                    placeholder="Enter your password"
                    required
                >

                @error('password')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-box">
                <input type="checkbox" name="remember" id="remember_me">
                <span>Remember Me</span>
            </div>

            <button type="submit" class="login-btn">
                Login
            </button>
            <div style="text-align:center; margin:20px 0; color:#9ca3af;">
                    OR
         </div>

<a href="{{ route('google.login') }}" 
   style="
        display:flex;
        align-items:center;
        justify-content:center;
        gap:10px;
        padding:14px;
        border:1px solid #d1d5db;
        border-radius:10px;
        text-decoration:none;
        color:#111;
        font-weight:600;
        transition:0.3s;
        background:white;
   "
   onmouseover="this.style.background='#f3f4f6'"
   onmouseout="this.style.background='white'"
>
    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
         style="width:18px; height:18px; display:block;">
    
    <span style="line-height:1;">
        Continue with Google
    </span>
</a>

            <div class="bottom-links">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif
           <a href="{{ route('register') }}">Create Account</a>

            </div>

        </form>

    </div>

