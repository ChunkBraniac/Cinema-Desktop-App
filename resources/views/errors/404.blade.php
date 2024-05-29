<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <title>404 Not Found</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f8f8;
            margin: 0;
            color: #333;
            font-family: Arial, sans-serif;
        }
        .error {
            font-size: 100px;
            animation: bounce 1s infinite;
        }
        .message {
            text-align: center;
        }
        .home-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>
<body>
    <div class="message">
        <div class="error">404</div>
        <p>Oops! Page not found.</p>

        <div class="mt-4">
            <a href="{{ route('movies.all') }}" class="home-btn text-decoration-none">Go Back Home</a>
        </div>
    </div>
</body>
</html>