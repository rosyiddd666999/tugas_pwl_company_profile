<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        :root {
            --primary: #00f5d4;
            --secondary: #7209b7;
            --accent: #f15bb5;
            --dark: #0a0a1a;
            --darker: #050510;
            --glass: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.12);
        }

        body {
            background: linear-gradient(135deg, var(--darker), var(--dark));
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* Background Effects */
        .bg-grid {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(90deg, transparent 24px, rgba(0, 245, 212, 0.02) 25px, rgba(0, 245, 212, 0.02) 26px, transparent 27px, transparent 74px, rgba(114, 9, 183, 0.02) 75px, rgba(114, 9, 183, 0.02) 76px, transparent 77px),
                linear-gradient(0deg, transparent 24px, rgba(0, 245, 212, 0.02) 25px, rgba(0, 245, 212, 0.02) 26px, transparent 27px, transparent 74px, rgba(114, 9, 183, 0.02) 75px, rgba(114, 9, 183, 0.02) 76px, transparent 77px);
            background-size: 100px 100px;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(100px, 100px); }
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.1;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: var(--primary);
            top: 10%;
            left: 10%;
            animation: float 15s ease-in-out infinite;
        }

        .shape-2 {
            width: 400px;
            height: 400px;
            background: var(--secondary);
            bottom: 10%;
            right: 10%;
            animation: float 18s ease-in-out infinite reverse;
        }

        .shape-3 {
            width: 200px;
            height: 200px;
            background: var(--accent);
            top: 50%;
            left: 80%;
            animation: float 12s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -50px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 10;
            width: 90%;
            max-width: 420px;
            background: var(--glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 50px 40px;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 45px;
        }

        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 25px;
        }

        .logo-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
            position: relative;
            overflow: hidden;
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .logo-icon i {
            font-size: 2rem;
            color: white;
            z-index: 1;
        }

        .logo-text h1 {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 10px rgba(0, 245, 212, 0.3);
        }

        .welcome-text h2 {
            color: white;
            font-size: 1.6rem;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .welcome-text p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 30px;
            position: relative;
        }

        .input-container {
            position: relative;
        }

        .input-field {
            width: 100%;
            padding: 20px 25px 20px 55px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            color: white;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 
                0 0 0 4px rgba(0, 245, 212, 0.15),
                0 10px 25px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.1rem;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .input-field:focus + .input-icon {
            color: var(--primary);
            transform: translateY(-50%) scale(1.1);
        }

        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
            background: none;
            border: none;
            font-size: 1.1rem;
        }

        .password-toggle:hover {
            color: var(--primary);
            transform: translateY(-50%) scale(1.1);
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 20px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 
                0 15px 30px rgba(0, 245, 212, 0.3),
                0 10px 20px rgba(114, 9, 183, 0.3);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        /* Loading Bar */
        .loading-bar {
            height: 4px;
            width: 0%;
            background: linear-gradient(90deg, var(--primary), var(--accent), var(--secondary));
            position: absolute;
            bottom: 0;
            left: 0;
            border-radius: 0 0 24px 24px;
            transition: width 0.4s ease;
        }

        /* Status Messages */
        .status-message {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .status-error {
            background: rgba(241, 91, 181, 0.1);
            color: var(--accent);
            border-left: 4px solid var(--accent);
        }

        .status-success {
            background: rgba(0, 245, 212, 0.1);
            color: var(--primary);
            border-left: 4px solid var(--primary);
        }

        .status-message i {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 40px 25px;
                margin: 20px;
            }
            
            .logo {
                flex-direction: column;
                text-align: center;
            }
            
            .logo-icon {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .welcome-text h2 {
                font-size: 1.4rem;
            }
        }

        /* Particle Effect */
        #particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
    </style>
</head>
<body>
    <!-- Background Effects -->
    <div class="bg-grid"></div>
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    <canvas id="particles"></canvas>

    <!-- Login Container -->
    <div class="login-container">
        <div class="loading-bar" id="loadingBar"></div>
        
        <div class="header">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="logo-text">
                    <h1>Welcome</h1>
                </div>
            </div>
            
            <div class="welcome-text">
                <h2>Employee </h2>
                <p>Enter your credentials to continue</p>
            </div>
        </div>

        <?php
        // PHP untuk menampilkan pesan error/success
        $error = isset($_GET['error']) ? $_GET['error'] : '';
        $success = isset($_GET['success']) ? $_GET['success'] : '';
        
        if ($error) {
            echo '<div class="status-message status-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>' . htmlspecialchars($error) . '</div>
                  </div>';
        }
        
        if ($success) {
            echo '<div class="status-message status-success">
                    <i class="fas fa-check-circle"></i>
                    <div>' . htmlspecialchars($success) . '</div>
                  </div>';
        }
        ?>
        
        <form action="authenticate.php" method="POST" id="loginForm">
            <div class="form-group">
                <div class="input-container">
                    <input type="email" id="email" name="email" class="input-field" placeholder="Enter your email" required 
                           value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
                    <i class="fas fa-envelope input-icon"></i>
                </div>
            </div>
            
            <div class="form-group">
                <div class="input-container">
                    <input type="password" id="password" name="password" class="input-field" placeholder="Enter your password" required>
                    <i class="fas fa-lock input-icon"></i>
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <button type="submit" class="btn-login" id="loginBtn">
                <span>Enter</span>
                <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
            </button>
        </form>
    </div>

    <script>
        // Simple Particle System
        const canvas = document.getElementById('particles');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let particlesArray = [];

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2;
                this.speedX = Math.random() * 0.5 - 0.25;
                this.speedY = Math.random() * 0.5 - 0.25;
                this.color = `rgba(0, 245, 212, ${Math.random() * 0.3})`;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                if (this.x > canvas.width) this.x = 0;
                if (this.x < 0) this.x = canvas.width;
                if (this.y > canvas.height) this.y = 0;
                if (this.y < 0) this.y = canvas.height;
            }

            draw() {
                ctx.fillStyle = this.color;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function init() {
            for (let i = 0; i < 50; i++) {
                particlesArray.push(new Particle());
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (let particle of particlesArray) {
                particle.update();
                particle.draw();
            }
            requestAnimationFrame(animate);
        }

        init();
        animate();

        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Form Submission with Loading Animation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const loadingBar = document.getElementById('loadingBar');
            const loginBtn = document.getElementById('loginBtn');
            const btnText = loginBtn.querySelector('span');
            const btnIcon = loginBtn.querySelector('i');
            
            // Show loading state
            loadingBar.style.width = '0%';
            loginBtn.disabled = true;
            btnText.textContent = 'Authenticating';
            btnIcon.className = 'fas fa-spinner fa-spin';
            
            // Animate loading bar
            let width = 0;
            const interval = setInterval(() => {
                if (width >= 100) {
                    clearInterval(interval);
                    // Submit the form
                    this.submit();
                } else {
                    width += 2;
                    loadingBar.style.width = width + '%';
                }
            }, 20);
        });

        // Input focus effects
        const inputs = document.querySelectorAll('.input-field');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Responsive canvas
        window.addEventListener('resize', function() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    </script>
</body>
</html>
