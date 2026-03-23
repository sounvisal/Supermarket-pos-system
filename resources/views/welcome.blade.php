<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Red Panda Supermarket</title>
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
        
        .login-container {
            max-width: 500px;
            width: 90%;
            margin: 2rem auto;
            padding: 2rem;
            background-color: var(--surface-white);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h2 {
            color: var(--primary-red);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: var(--text-secondary);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-primary);
        }
        
        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--primary-red);
            box-shadow: 0 0 0 2px rgba(217, 78, 51, 0.2);
        }
        
        .role-selection {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .role-option {
            flex: 1;
            min-width: 120px;
        }
        
        .role-option input[type="radio"] {
            display: none;
        }
        
        .role-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .role-option input[type="radio"]:checked + label {
            border-color: var(--primary-red);
            background-color: var(--light-red);
        }
        
        .role-option i {
            font-size: 2rem;
            margin-bottom: 0.75rem;
            color: var(--primary-red);
        }
        
        .role-option .role-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .role-option .role-desc {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }
        
        .submit-btn {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(217, 78, 51, 0.3);
        }
        
        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }
        
        .forgot-password a {
            color: var(--primary-red);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .forgot-password a:hover {
            color: var(--primary-red-dark);
            text-decoration: underline;
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
        
        @media screen and (max-width: 768px) {
            .login-container {
                width: 95%;
                padding: 1.5rem;
            }
            
            .role-selection {
                flex-direction: column;
            }
            
            .role-option {
                width: 100%;
            }
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
        <div class="login-container">
            <div class="login-header">
                <h2>Employee Login</h2>
                <p>Sign in to access the supermarket management system</p>
            </div>
            
            <form action="{{ route('authenticate') }}" method="POST">
                @csrf
                
                @if ($errors->any())
                    <div class="alert-error" style="background-color: #ffebee; border: 1px solid #ef5350; color: #c62828; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="form-group">
                    <label for="employee_id">Employee ID</label>
                    <input type="text" id="employee_id" name="employee_id" required placeholder="Enter your employee ID" value="{{ old('employee_id') }}">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                
                <div class="form-group">
                    <label>Select Your Role</label>
                    <div class="role-selection">
                        <div class="role-option">
                            <input type="radio" id="cashier" name="role" value="cashier" required>
                            <label for="cashier">
                                <i class="fas fa-cash-register"></i>
                                <div class="role-name">Cashier</div>
                                <div class="role-desc">Access charge page for checkout operations</div>
                            </label>
                        </div>
                        
                        <div class="role-option">
                            <input type="radio" id="manager" name="role" value="manager">
                            <label for="manager">
                                <i class="fas fa-chart-line"></i>
                                <div class="role-name">Manager</div>
                                <div class="role-desc">Full access to dashboard and employee management</div>
                            </label>
                        </div>
                        
                        <div class="role-option">
                            <input type="radio" id="stock" name="role" value="stock">
                            <label for="stock">
                                <i class="fas fa-boxes"></i>
                                <div class="role-name">Stock Staff</div>
                                <div class="role-desc">Access product inventory management</div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">Sign In</button>
                
            
            </form>
        </div>
    </main>
    
    <footer>
        <div class="footer-content">
            <p>&copy; {{ now()->setTimezone('Asia/Phnom_Penh')->format('Y') }} Red Panda Supermarket System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
