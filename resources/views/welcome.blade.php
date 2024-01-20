<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EmployeeManagement</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #A6B695;
            color: #4B5563;
            text-align: center;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #2C3128;
        }

        p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            color: #FFFFFF;
        }

        a {
            text-decoration: none;
            color: #4B5563;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border: 2px solid #4B5563;
            border-radius: 0.5rem;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover {
            background-color: #4B5563;
            color: #A6B695;
        }
    </style>
</head>
<body class="antialiased">
    <h1>Employee Management App</h1>
    <p>Log in if you have an account or sign up if you are new!</p>
    
    @if (Route::has('login'))
        <div>
            @auth
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.home') }}">Home</a>
                @else
                    <a href="{{ route('home') }}">Home</a>
                @endif
            @else
                <a href="{{ route('login') }}">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4">Register</a>
                @endif
            @endauth
        </div>
    @endif
</body>
</html>
