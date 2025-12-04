<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased" style="background-color: #ffffff !important;">
        <div class="flex min-h-svh" style="background-color: #ffffff !important;">
            <!-- Left Side - Phone Mockups -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-orange-50 via-orange-100 to-orange-50 items-center justify-center p-12 relative overflow-hidden">
                <!-- Background Decorative Elements -->
                <div class="absolute top-20 left-20 w-32 h-32 bg-orange-200 rounded-full opacity-20 blur-3xl"></div>
                <div class="absolute bottom-20 right-20 w-40 h-40 bg-orange-300 rounded-full opacity-20 blur-3xl"></div>
                
                <div class="relative max-w-2xl w-full">
                    <!-- Main Heading -->
                    <div class="mb-12 text-center">
                        <h1 class="text-5xl font-bold text-gray-900 mb-4">
                            Streamline your
                            <span class="text-orange-600 typewriter-text" data-text="financial"></span>
                            <br/>workflow
                        </h1>
                        <p class="text-xl text-gray-600 fade-in-text">Manage budgets, approvals, and payments in one place</p>
                    </div>
                    
                    <style>
                        @keyframes typing {
                            from { width: 0; }
                            to { width: 100%; }
                        }
                        
                        @keyframes blink {
                            50% { border-color: transparent; }
                        }
                        
                        @keyframes fadeIn {
                            from { opacity: 0; transform: translateY(10px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                        
                        .typewriter-text {
                            display: inline-block;
                            overflow: hidden;
                            border-right: 3px solid #f97316;
                            white-space: nowrap;
                            animation: typing 2s steps(9, end) 0.5s forwards, blink 0.75s step-end infinite;
                            width: 0;
                        }
                        
                        .fade-in-text {
                            opacity: 0;
                            animation: fadeIn 1s ease-out 2.5s forwards;
                        }
                    </style>
                    
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const typewriterElement = document.querySelector('.typewriter-text');
                            if (typewriterElement) {
                                const text = typewriterElement.getAttribute('data-text');
                                typewriterElement.textContent = text;
                            }
                        });
                    </script>
                    
                    <!-- Phone Mockups Container -->
                    <div class="relative h-[500px] flex items-center justify-center">
                        <!-- Left Phone (Slightly Behind) -->
                        <div class="absolute left-0 top-8 transform -rotate-6 hover:rotate-0 transition-transform duration-300">
                            <div class="w-64 h-[480px] bg-gray-900 rounded-[3rem] shadow-2xl p-3 border-8 border-gray-800">
                                <div class="w-full h-full bg-white rounded-[2.2rem] overflow-hidden">
                                    <!-- Phone Screen Content - Dashboard -->
                                    <div class="h-full bg-gradient-to-b from-orange-50 to-white p-4">
                                        <!-- Status Bar -->
                                        <div class="flex justify-between items-center mb-4 text-xs text-gray-600">
                                            <span>9:41</span>
                                            <div class="flex gap-1">
                                                <div class="w-4 h-3 border border-gray-600 rounded-sm"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Header -->
                                        <div class="mb-4">
                                            <h3 class="text-lg font-bold text-gray-900">Dashboard</h3>
                                            <p class="text-xs text-gray-500">Financial Overview</p>
                                        </div>
                                        
                                        <!-- Stats Cards -->
                                        <div class="space-y-3">
                                            <div class="bg-white rounded-xl p-3 shadow-sm border border-orange-100">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <p class="text-xs text-gray-500">Pending</p>
                                                        <p class="text-2xl font-bold text-orange-600">12</p>
                                                    </div>
                                                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="bg-white rounded-xl p-3 shadow-sm border border-green-100">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <p class="text-xs text-gray-500">Approved</p>
                                                        <p class="text-2xl font-bold text-green-600">45</p>
                                                    </div>
                                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="bg-white rounded-xl p-3 shadow-sm border border-gray-100">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <p class="text-xs text-gray-500">Budget</p>
                                                        <p class="text-lg font-bold text-gray-900">$2.4M</p>
                                                    </div>
                                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Center Phone (Front and Center) -->
                        <div class="relative z-10 transform hover:scale-105 transition-transform duration-300">
                            <div class="w-72 h-[520px] bg-gray-900 rounded-[3rem] shadow-2xl p-3 border-8 border-gray-800">
                                <div class="w-full h-full bg-white rounded-[2.2rem] overflow-hidden">
                                    <!-- Phone Screen Content - Payment Request -->
                                    <div class="h-full bg-gradient-to-b from-white to-orange-50 p-4">
                                        <!-- Status Bar -->
                                        <div class="flex justify-between items-center mb-4 text-xs text-gray-600">
                                            <span>9:41</span>
                                            <div class="flex gap-1">
                                                <div class="w-4 h-3 border border-gray-600 rounded-sm"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Header -->
                                        <div class="mb-6">
                                            <div class="flex items-center gap-2 mb-2">
                                                <div class="w-8 h-8 bg-orange-600 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-sm font-bold text-gray-900">Payment Request</h3>
                                                    <p class="text-xs text-gray-500">#PR-2024-001</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Request Details -->
                                        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 mb-4">
                                            <div class="space-y-3">
                                                <div>
                                                    <p class="text-xs text-gray-500 mb-1">Title</p>
                                                    <p class="text-sm font-semibold text-gray-900">Office Equipment</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500 mb-1">Amount</p>
                                                    <p class="text-2xl font-bold text-orange-600">$15,750</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500 mb-1">Type</p>
                                                    <span class="inline-block px-2 py-1 bg-orange-100 text-orange-700 text-xs font-medium rounded-full">CAPEX</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Approval Status -->
                                        <div class="bg-green-50 rounded-2xl p-4 border border-green-100">
                                            <div class="flex items-center gap-2 mb-2">
                                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-semibold text-green-700">Approved by FM</p>
                                            </div>
                                            <p class="text-xs text-green-600">Waiting for CEO approval</p>
                                        </div>
                                        
                                        <!-- Action Button -->
                                        <div class="mt-6">
                                            <div class="bg-gray-900 text-white text-center py-3 rounded-xl font-semibold text-sm">
                                                View Details
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Phone (Slightly Behind) -->
                        <div class="absolute right-0 top-8 transform rotate-6 hover:rotate-0 transition-transform duration-300">
                            <div class="w-64 h-[480px] bg-gray-900 rounded-[3rem] shadow-2xl p-3 border-8 border-gray-800">
                                <div class="w-full h-full bg-white rounded-[2.2rem] overflow-hidden">
                                    <!-- Phone Screen Content - Budgets -->
                                    <div class="h-full bg-gradient-to-b from-white to-orange-50 p-4">
                                        <!-- Status Bar -->
                                        <div class="flex justify-between items-center mb-4 text-xs text-gray-600">
                                            <span>9:41</span>
                                            <div class="flex gap-1">
                                                <div class="w-4 h-3 border border-gray-600 rounded-sm"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Header -->
                                        <div class="mb-4">
                                            <h3 class="text-lg font-bold text-gray-900">Budgets</h3>
                                            <p class="text-xs text-gray-500">2024 Overview</p>
                                        </div>
                                        
                                        <!-- Budget Cards -->
                                        <div class="space-y-3">
                                            <div class="bg-white rounded-xl p-3 shadow-sm border border-gray-100">
                                                <div class="flex justify-between items-start mb-2">
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-900">IT Department</p>
                                                        <p class="text-xs text-gray-500">OPEX</p>
                                                    </div>
                                                    <span class="text-xs font-medium text-green-600">78%</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-orange-500 h-2 rounded-full" style="width: 78%"></div>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">$780K / $1M</p>
                                            </div>
                                            
                                            <div class="bg-white rounded-xl p-3 shadow-sm border border-gray-100">
                                                <div class="flex justify-between items-start mb-2">
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-900">Marketing</p>
                                                        <p class="text-xs text-gray-500">OPEX</p>
                                                    </div>
                                                    <span class="text-xs font-medium text-orange-600">45%</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-orange-500 h-2 rounded-full" style="width: 45%"></div>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">$225K / $500K</p>
                                            </div>
                                            
                                            <div class="bg-white rounded-xl p-3 shadow-sm border border-gray-100">
                                                <div class="flex justify-between items-start mb-2">
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-900">Infrastructure</p>
                                                        <p class="text-xs text-gray-500">CAPEX</p>
                                                    </div>
                                                    <span class="text-xs font-medium text-red-600">92%</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-red-500 h-2 rounded-full" style="width: 92%"></div>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">$1.84M / $2M</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Feature Pills -->
                    <div class="mt-12 flex flex-wrap justify-center gap-3">
                        <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm border border-orange-100">
                            <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Real-time Approvals</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm border border-orange-100">
                            <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Budget Tracking</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm border border-orange-100">
                            <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Push Notifications</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Login Form -->
            <div class="flex w-full lg:w-1/2 flex-col items-center justify-center gap-6 p-6 md:p-10">
                <div class="flex w-full max-w-sm flex-col gap-8">
                    <div class="flex flex-col items-center gap-3">
                        <div class="flex items-center gap-3 text-3xl font-bold">
                            <span class="text-orange-600 typewriter-logo" data-text="mNotify"></span>
                            <span class="text-gray-400 logo-divider" style="opacity: 0;">|</span>
                            <span class="text-gray-900 typewriter-logo-2" data-text="BudgetIQ"></span>
                        </div>
                        <p class="text-sm text-center subtitle-fade" style="color: #6b7280 !important; opacity: 0;">OPEX/CAPEX Management System</p>
                    </div>
                    
                    <style>
                        .typewriter-logo {
                            display: inline-block;
                            overflow: hidden;
                            white-space: nowrap;
                            width: 0;
                            animation: typing-logo 1s steps(7, end) forwards, removeOverflow 0s 1s forwards;
                        }
                        
                        .logo-divider {
                            animation: fadeInDivider 0.3s ease-in 1s forwards;
                        }
                        
                        .typewriter-logo-2 {
                            display: inline-block;
                            overflow: hidden;
                            white-space: nowrap;
                            width: 0;
                            animation: typing-logo-2 1s steps(8, end) 1.2s forwards, removeOverflow 0s 2.2s forwards;
                        }
                        
                        .subtitle-fade {
                            animation: fadeInSubtitle 0.8s ease-out 2.3s forwards;
                        }
                        
                        @keyframes typing-logo {
                            from { width: 0; }
                            to { width: 100%; }
                        }
                        
                        @keyframes typing-logo-2 {
                            from { width: 0; }
                            to { width: 100%; }
                        }
                        
                        @keyframes removeOverflow {
                            to { overflow: visible; }
                        }
                        
                        @keyframes fadeInDivider {
                            from { opacity: 0; }
                            to { opacity: 1; }
                        }
                        
                        @keyframes fadeInSubtitle {
                            from { opacity: 0; transform: translateY(5px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                    </style>
                    
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const logo1 = document.querySelector('.typewriter-logo');
                            const logo2 = document.querySelector('.typewriter-logo-2');
                            
                            if (logo1) {
                                logo1.textContent = logo1.getAttribute('data-text');
                            }
                            if (logo2) {
                                logo2.textContent = logo2.getAttribute('data-text');
                                
                                // Remove overflow after animation completes to show full Q
                                setTimeout(() => {
                                    logo2.style.overflow = 'visible';
                                }, 2200);
                            }
                        });
                    </script>
                    <div class="flex flex-col gap-6" style="color: #000000 !important;">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
