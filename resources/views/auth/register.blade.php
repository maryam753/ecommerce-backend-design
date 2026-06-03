    <style>
        body{
            background: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
        }

        .register-container{
            width: 420px;
            background: #fff;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin: 40px auto;
        }

        .register-title{
            font-size: 32px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 5px;
        }

        .register-subtitle{
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

        .register-btn{
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

        .register-btn:hover{
            background: #222;
        }

        .bottom-link{
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .bottom-link a{
            color: black;
            font-weight: 600;
            text-decoration: none;
        }

        .error-text{
            color: red;
            font-size: 13px;
            margin-top: 5px;
        }

        .logo{
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 25px;
            color: black;
        }
    </style>

    <div class="register-container">

        <div class="logo">
            BRAND
        </div>

        <h2 class="register-title">Create Account</h2>

        <p class="register-subtitle">
            Register to continue shopping with us.
        </p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="input-group">

                <label class="input-label">Full Name</label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="custom-input"
                    placeholder="Enter your name"
                    required
                >

                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror

            </div>

            <!-- Email -->
            <div class="input-group">

                <label class="input-label">Email Address</label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="custom-input"
                    placeholder="Enter your email"
                    required
                >

                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror

            </div>

            <!-- Password -->
            <div class="input-group">

                <label class="input-label">Password</label>

                <input
                    type="password"
                    name="password"
                    class="custom-input"
                    placeholder="Create password"
                    required
                >

                @error('password')
                    <div class="error-text">{{ $message }}</div>
                @enderror

            </div>

            <!-- Confirm Password -->
            <div class="input-group">

                <label class="input-label">Confirm Password</label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="custom-input"
                    placeholder="Confirm password"
                    required
                >

                @error('password_confirmation')
                    <div class="error-text">{{ $message }}</div>
                @enderror

            </div>

            <!-- Button -->
            <button type="submit" class="register-btn">
                Create Account
            </button>

            <!-- Login Link -->
            <div class="bottom-link">

                Already have an account?

                 <a href="{{ route('login') }}">Login</a>

            </div>

        </form>

    </div>

