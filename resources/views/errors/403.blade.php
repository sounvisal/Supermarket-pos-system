<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied - Red Panda Supermarket</title>
    <link href="{{ asset('images/logo.png') }}" rel="icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        :root {
            --primary-red: #D94E33;
            --primary-red-dark: #912B10;
            --light-red: #FFF1EC;
            --accent-orange: #F79E56;
            --accent-orange-dark: #E98B3D;
            --accent-brown: #70280B;
            --background-light: #FEF8F5;
            --surface-white: #FFFFFF;
            --text-primary: #3D2217;
            --text-secondary: #7A6158;
            --border-color: #F0E6E2;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: var(--background-light);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        header {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 10px rgba(145, 43, 16, 0.2);
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .logo img {
            width: 40px;
            height: 40px;
            margin-right: 1rem;
        }
        
        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .error-container {
            max-width: 600px;
            width: 90%;
            margin: 2rem auto;
            padding: 2rem;
            background-color: var(--surface-white);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .error-icon {
            font-size: 5rem;
            color: var(--primary-red);
            margin-bottom: 1rem;
        }
        
        .error-title {
            font-size: 2rem;
            color: var(--primary-red);
            margin-bottom: 1rem;
        }
        
        .error-message {
            margin-bottom: 2rem;
            color: var(--text-secondary);
        }
        
        .back-button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(217, 78, 51, 0.3);
        }
        
        footer {
            background-color: var(--text-primary);
            color: white;
            padding: 1.5rem;
            margin-top: auto;
            text-align: center;
        }
        
        .footer-content p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Red Panda Logo">
            <h1>Red Panda Supermarket</h1>
        </div>
    </header>
    
    <main>
        <div class="error-container">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h1 class="error-title">Access Denied</h1>
            <p class="error-message">
                Sorry, you do not have permission to access this page. 
                Please contact your manager if you believe this is an error.
            </p>
            <a href="/" class="back-button">Back to Login</a>
        </div>
    </main>
    
    <footer>
        <div class="footer-content">
            <p>&copy; {{ date('Y') }} Red Panda Supermarket System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html> 