<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se Connecter - EduX</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'yellow-custom': '#FFD700',
                    'yellow-bright': '#FFEB3B'
                },
                animation: {
                    'float': 'float 3s ease-in-out infinite',
                    'float-delayed': 'float 3s ease-in-out 1.5s infinite',
                    'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    'slide-in': 'slideIn 0.6s ease-out',
                    'bounce-in': 'bounceIn 0.8s ease-out'
                }
            }
        }
    }
    </script>
    <style>
    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-15px);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.3);
        }

        50% {
            opacity: 1;
            transform: scale(1.05);
        }

        70% {
            transform: scale(0.9);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    .geometric-shape {
        transition: all 0.4s ease;
    }

    .geometric-shape:hover {
        transform: rotate(180deg) scale(1.2);
    }

    .input-group {
        position: relative;
    }

    .input-group input:focus+label,
    .input-group input:not(:placeholder-shown)+label {
        transform: translateY(-24px) scale(0.85);
        color: #000;
    }

    .input-group label {
        position: absolute;
        left: 16px;
        top: 16px;
        color: #6B7280;
        transition: all 0.2s ease;
        pointer-events: none;
        background: white;
        padding: 0 4px;
    }

    .form-container {
        backdrop-filter: blur(20px);
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 font-sans overflow-hidden">

    <!-- Background Geometric Elements -->
    <div class="fixed inset-0 pointer-events-none">
        <!-- Large background circle -->
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-yellow-400 rounded-full opacity-20 animate-pulse-slow">
        </div>

        <!-- Floating geometric shapes -->
        <div class="absolute top-20 left-20 w-8 h-8 bg-yellow-400 rounded-full animate-float"></div>
        <div class="absolute top-40 right-32 w-6 h-6 bg-black rounded-full animate-float-delayed"></div>
        <div class="absolute bottom-32 left-16 geometric-shape">
            <div class="w-12 h-12 border-3 border-yellow-400 transform rotate-45"></div>
        </div>
        <div class="absolute bottom-20 right-20 geometric-shape">
            <div class="w-10 h-10 border-2 border-gray-300 transform rotate-45"></div>
        </div>
        <div class="absolute top-1/2 left-10 w-4 h-4 bg-yellow-400 rounded-full animate-pulse-slow"></div>

        <!-- Large geometric shape -->
        <div class="absolute -bottom-20 -left-20 w-64 h-64 border-4 border-gray-200 transform rotate-45 opacity-30">
        </div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 flex items-center justify-center min-h-[120vh] py-20 px-6 overflow-y-auto">
        <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-12 items-center">

            <!-- Left Side - Illustration -->
            <div class="hidden lg:flex justify-center items-center relative mb-20">
                <div class="relative animate-bounce-in">
                    <!-- Main illustration circle -->
                    <div
                        class="w-96 h-96 bg-yellow-400 rounded-full flex items-center justify-center relative overflow-hidden">
                        <!-- Character with laptop -->
                        <div class="relative z-10">
                            <!-- Person outline -->
                            <div class="w-40 h-48 relative mb-8">
                                <!-- Head -->
                                <div class="w-16 h-16 bg-white rounded-full mx-auto mb-4 relative">
                                    <div class="absolute top-4 left-3 w-2 h-2 bg-black rounded-full"></div>
                                    <div class="absolute top-4 right-3 w-2 h-2 bg-black rounded-full"></div>
                                    <div
                                        class="absolute bottom-3 left-1/2 transform -translate-x-1/2 w-4 h-1 bg-black rounded-full">
                                    </div>
                                </div>

                                <!-- Body -->
                                <div class="w-20 h-24 bg-white rounded-t-full mx-auto relative">
                                    <!-- Arms -->
                                    <div
                                        class="absolute -left-6 top-4 w-12 h-3 bg-white rounded-full transform -rotate-12">
                                    </div>
                                    <div
                                        class="absolute -right-6 top-4 w-12 h-3 bg-white rounded-full transform rotate-12">
                                    </div>
                                </div>
                            </div>

                            <!-- Laptop -->
                            <div class="w-32 h-20 bg-gray-800 rounded-lg mx-auto relative transform -mt-4">
                                <div
                                    class="w-28 h-16 bg-white rounded-sm absolute top-2 left-2 flex items-center justify-center">
                                    <!-- Screen content -->
                                    <div class="space-y-1">
                                        <div class="w-16 h-1 bg-yellow-400 rounded"></div>
                                        <div class="w-12 h-1 bg-gray-300 rounded"></div>
                                        <div class="w-20 h-1 bg-gray-300 rounded"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative elements inside circle -->
                        <div class="absolute top-10 left-10 w-8 h-8 bg-white rounded-full opacity-60 animate-float">
                        </div>
                        <div
                            class="absolute bottom-20 right-16 w-6 h-6 bg-black rounded-full opacity-40 animate-float-delayed">
                        </div>
                    </div>

                    <!-- Floating elements around illustration -->
                    <div class="absolute -top-8 -right-8 w-16 h-16 bg-black rounded-full animate-float"></div>
                    <div
                        class="absolute -bottom-8 -left-8 w-20 h-20 border-4 border-yellow-400 transform rotate-45 animate-float-delayed">
                    </div>
                    <div class="absolute top-20 -left-12 w-8 h-8 bg-yellow-400 rounded-full animate-pulse-slow"></div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="animate-slide-in mb-20">
                <div class="form-container rounded-3xl p-8 lg:p-12 shadow-2xl max-w-md mx-auto">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-yellow-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <div class="w-8 h-8 bg-black rounded-full"></div>
                        </div>
                        <h1 class="text-3xl font-bold mb-2">Bon Retour !</h1>
                        <p class="text-gray-600">Connectez-vous pour continuer votre apprentissage</p>
                    </div>

                    <!-- Login Form -->
                    <form class="space-y-6" method="POST" action="login.php">
                        <!-- Email Input -->
                        <div class="input-group">
                            <input type="email" id="email" placeholder=" "
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:outline-none transition-all duration-200 bg-white/50"
                                required>
                            <label for="email">Adresse email</label>
                        </div>

                        <!-- Password Input -->
                        <div class="input-group">
                            <input type="password" id="password" placeholder=" "
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-yellow-400 focus:outline-none transition-all duration-200 bg-white/50"
                                required>
                            <label for="password">Mot de passe</label>
                        </div>

                        <!-- Remember & comeback -->
                        <div class="flex justify-between items-center text-sm">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <span class="text-gray-600">Aller à l'accueil</span>
                            </label>
                            <a href="forgot_password.php" class="text-yellow-600 hover:text-yellow-700 font-medium">
                                Mot de passe oublié ?
                            </a>
                        </div>

                        <!-- Login Button -->
                        <button type="submit"
                            class="w-full bg-black text-white py-4 rounded-xl font-semibold hover:bg-gray-800 transition-all duration-300 hover:scale-105 transform hover:shadow-lg">
                            Se Connecter
                        </button>


                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Add form validation and interaction effects
    const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');

    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });

    // Add subtle parallax effect for background elements
    window.addEventListener('mousemove', (e) => {
        const shapes = document.querySelectorAll('.geometric-shape');
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;

        shapes.forEach((shape, index) => {
            const speed = (index + 1) * 0.02;
            const x = (mouseX - 0.5) * speed * 100;
            const y = (mouseY - 0.5) * speed * 100;

            shape.style.transform = `translate(${x}px, ${y}px) rotate(45deg)`;
        });
    });

    // Form submission with loading effect
    const form = document.querySelector('form');
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Loading state
        submitBtn.innerHTML = `
                <div class="flex items-center justify-center space-x-2">
                    <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    <span>Connexion...</span>
                </div>
            `;

        // Simulate loading
        setTimeout(() => {
            submitBtn.innerHTML = 'Se Connecter';
            // Here you would typically handle the actual login
            alert('Connexion simulée réussie !');
        }, 2000);
    });

    // Add entrance animation delay for form elements
    const formElements = document.querySelectorAll('.input-group, button, .text-center');
    formElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';

        setTimeout(() => {
            element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 100 + 300);
    });
    </script>
</body>

</html>