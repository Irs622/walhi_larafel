<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('partials.seo-meta', ['title' => 'Dukung Gerakan - WALHI Jawa Barat'])

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/fonts/webfonts/font-face.css') }}">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Lucide Script for Icons -->
        <script nonce="{{ Vite::cspNonce() }}" src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js" integrity="sha384-ieG+IKD0d/ZPXyCBTMVAbqsQdns8QGJR/e26WMw7M4fkaI/rHcS/YIoi+ah9WGge" crossorigin="anonymous"></script>

        <!-- Midtrans Snap -->
        @if(config('midtrans.client_key'))
            @if(config('midtrans.is_production'))
                <script nonce="{{ Vite::cspNonce() }}" src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
            @else
                <script nonce="{{ Vite::cspNonce() }}" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
            @endif
        @else
            <script nonce="{{ Vite::cspNonce() }}" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="dummy-client-key"></script>
        @endif
        
        <style>
            .hover-pillar-card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .hover-pillar-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
            }
            
            .amount-btn {
                transition: all 0.2s ease;
                background: white;
                color: #1D1D1D;
                border: 2px solid #1D1D1D;
                cursor: pointer;
            }
            .amount-btn:hover {
                background: #F4F1EA;
            }
            .amount-btn.active {
                background: #1D1D1D !important;
                color: #F4F1EA !important;
                border-color: #1D1D1D !important;
            }
            
            .input-field {
                width: 100%;
                height: 60px;
                padding: 16px 24px;
                border: 2px solid #1D1D1D;
                font-family: Montserrat, sans-serif;
                font-size: 16px;
                background: white;
                box-sizing: border-box;
                outline: none;
                color: #1D1D1D;
                transition: border-color 0.2s;
            }
            .input-field:focus {
                border-color: #256D4A;
            }
            
            .submit-btn {
                background: #D95C3F;
                color: #F4F1EA;
                border: none;
                outline: 2px solid #D95C3F;
                outline-offset: -2px;
                cursor: pointer;
                transition: background 0.2s;
            }
            .submit-btn:hover {
                background: #256D4A;
                outline-color: #256D4A;
            }
            
            /* Responsive Utilities */
            @media (max-width: 900px) {
                .why-donate-section {
                    padding: 48px 32px !important;
                }
                .why-donate-grid {
                    grid-template-columns: 1fr !important;
                    gap: 24px !important;
                }
                .form-outer-container {
                    padding: 48px 24px !important;
                }
            }
            
            @media (max-width: 640px) {
                .amount-grid {
                    grid-template-columns: repeat(2, 1fr) !important;
                }
            }
        </style>
    </head>
    <body style="width: 100%; background: #F4F1EA; margin: 0; overflow-x: clip; color: #1D1D1D; font-family: Montserrat, sans-serif;">
        <div style="position: relative; width: 100%; overflow-x: clip; background: #F4F1EA;">
            @include('partials.site-header')

            <main style="display: flex; flex-direction: column; align-items: stretch;">
                
                <!-- Hero Section -->
                <section style="background: #1D1D1D; border-bottom: 4px #256D4A solid; color: #F4F1EA;" class="py-12 md:py-16">
                    <div class="w-full max-w-5xl mx-auto px-4 sm:px-8">
                        <div style="display: flex; flex-direction: column; gap: 24px; max-width: 860px; width: 100%;">
                            <!-- Breadcrumbs -->
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-family: Montserrat, sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px;">
                                <a href="{{ route('home') }}" style="color: #F4F1EA; text-decoration: none; opacity: 0.8;">Beranda</a>
                                <span style="color: #256D4A; font-weight: 400; font-size: 16px;">/</span>
                                <span style="color: #F4F1EA; opacity: 0.8;">Dukung Kami</span>
                                <span style="color: #256D4A; font-weight: 400; font-size: 16px;">/</span>
                                <span style="color: #5C8D59;">Donasi Publik</span>
                            </div>
                            
                            <h1 style="margin: 0; color: #F4F1EA; font-size: clamp(48px, 7vw, 76px); font-family: Aspekta, sans-serif; font-weight: 800; line-height: 1.05; letter-spacing: 1px; text-transform: uppercase;">
                                DONASI PUBLIK
                            </h1>
                            <div style="width: 128px; height: 8px; background: #D95C3F;"></div>
                            <p style="margin: 0; color: #5C8D59; font-size: 20px; line-height: 32px; font-family: Montserrat, sans-serif; font-weight: 500;">
                                Dukung Perjuangan Keadilan Ekologis
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Why Donate Section -->
                <section style="background: #F4F1EA; color: #1D1D1D;" class="py-16 md:py-20">
                    <div class="w-full max-w-5xl mx-auto px-4 sm:px-8 flex flex-col gap-10">
                        
                        <!-- Green Callout Block -->
                        <div style="background: #256D4A; border: 4px solid #256D4A; outline: 4px #256D4A solid; outline-offset: -4px; padding: 52px; display: flex; flex-direction: column; align-items: center; gap: 36px; box-sizing: border-box; color: #F4F1EA;" class="why-donate-section">
                            <div style="text-align: center; max-width: 720px; display: flex; flex-direction: column; gap: 16px;">
                                <h2 style="margin: 0; font-family: Aspekta, sans-serif; font-size: clamp(32px, 5vw, 44px); font-weight: 800; text-transform: uppercase; letter-spacing: 1px; line-height: 1.2;">
                                    MENGAPA DONASI KE WALHI?
                                </h2>
                                <p style="margin: 0; font-family: Montserrat, sans-serif; font-size: 18px; line-height: 1.7; opacity: 0.95;">
                                    WALHI Jawa Barat adalah organisasi independen yang tidak menerima dana dari korporasi atau pemerintah. Kami 100% didanai oleh masyarakat. Setiap rupiah yang Anda berikan langsung mendukung perjuangan keadilan ekologis.
                                </p>
                            </div>
                            
                            <!-- Pillars Grid -->
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; width: 100%;" class="why-donate-grid">
                                <!-- Pillar 1 -->
                                <div style="background: white; border: 4px solid white; outline: 4px #F4F1EA solid; outline-offset: -4px; padding: 32px; display: flex; flex-direction: column; align-items: center; gap: 16px; box-sizing: border-box; color: #1D1D1D; text-align: center;" class="hover-pillar-card">
                                    <div style="width: 72px; height: 72px; background: #1D1D1D; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #256D4A;">
                                        <i data-lucide="shield-alert" style="width: 32px; height: 32px;"></i>
                                    </div>
                                    <h3 style="margin: 0; font-family: Aspekta, sans-serif; font-weight: 700; font-size: 20px; letter-spacing: 0.5px; text-transform: uppercase;">Pendampingan Rakyat</h3>
                                    <p style="margin: 0; font-family: Montserrat, sans-serif; font-size: 14px; line-height: 1.6; color: #555;">
                                        Donasi membantu kami mendampingi komunitas yang terdampak kerusakan lingkungan, memberikan bantuan hukum dan advokasi.
                                    </p>
                                </div>
                                
                                <!-- Pillar 2 -->
                                <div style="background: white; border: 4px solid white; outline: 4px #F4F1EA solid; outline-offset: -4px; padding: 32px; display: flex; flex-direction: column; align-items: center; gap: 16px; box-sizing: border-box; color: #1D1D1D; text-align: center;" class="hover-pillar-card">
                                    <div style="width: 72px; height: 72px; background: #1D1D1D; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #5C8D59;">
                                        <i data-lucide="bar-chart-3" style="width: 32px; height: 32px;"></i>
                                    </div>
                                    <h3 style="margin: 0; font-family: Aspekta, sans-serif; font-weight: 700; font-size: 20px; letter-spacing: 0.5px; text-transform: uppercase;">Investigasi & Riset</h3>
                                    <p style="margin: 0; font-family: Montserrat, sans-serif; font-size: 14px; line-height: 1.6; color: #555;">
                                        Dana untuk investigasi mendalam kerusakan lingkungan, pengumpulan data, dan produksi laporan berkualitas.
                                    </p>
                                </div>
                                
                                <!-- Pillar 3 -->
                                <div style="background: white; border: 4px solid white; outline: 4px #F4F1EA solid; outline-offset: -4px; padding: 32px; display: flex; flex-direction: column; align-items: center; gap: 16px; box-sizing: border-box; color: #1D1D1D; text-align: center;" class="hover-pillar-card">
                                    <div style="width: 72px; height: 72px; background: #1D1D1D; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #8B6B4A;">
                                        <i data-lucide="megaphone" style="width: 32px; height: 32px;"></i>
                                    </div>
                                    <h3 style="margin: 0; font-family: Aspekta, sans-serif; font-weight: 700; font-size: 20px; letter-spacing: 0.5px; text-transform: uppercase;">Kampanye Publik</h3>
                                    <p style="margin: 0; font-family: Montserrat, sans-serif; font-size: 14px; line-height: 1.6; color: #555;">
                                        Membiayai kampanye kesadaran lingkungan, aksi lapangan, dan gerakan massa untuk perubahan kebijakan.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Donation Form Block -->
                        <!-- Donation Form Block -->
                        <div style="background: white; border: 4px solid #1D1D1D; outline: 4px #1D1D1D solid; outline-offset: -4px; padding: 52px 96px; display: flex; flex-direction: column; gap: 32px; box-sizing: border-box;" class="form-outer-container">
                            
                            <!-- WhatsApp Narrative Card -->
                            <div style="background: #256D4A; border: 3px solid #1D1D1D; padding: 24px; color: #F4F1EA; display: flex; flex-direction: column; gap: 12px; text-align: center; box-shadow: 4px 4px 0px 0px #1D1D1D;">
                                <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #1D1D1D; background: #F4F1EA; display: inline-block; padding: 4px 12px; margin: 0 auto;">Layanan Donasi Langsung</div>
                                <p style="margin: 0; font-size: 17px; font-weight: 600; line-height: 1.6; font-family: Montserrat, sans-serif;">
                                    “Ingin berdonasi untuk lingkungan hidup? Hubungi WA dibawah ini untuk mengetahui manfaat apa saja yang akan kamu terima :)”
                                </p>
                                <div style="margin-top: 6px;">
                                    <a href="https://wa.me/6282119821159?text=Halo%20WALHI%20Jawa%20Barat,%20saya%20ingin%20berdonasi%20untuk%20lingkungan%20hidup.%20Mohon%20informasi%20manfaat%20apa%20saja%20yang%20akan%20saya%20terima%20:)" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: #D95C3F; color: #FFFFFF; padding: 12px 24px; font-weight: 700; font-size: 14px; text-transform: uppercase; text-decoration: none; border: 2px solid #FFFFFF; transition: background 0.2s;" onmouseover="this.style.background='#c44e32'" onmouseout="this.style.background='#D95C3F'">
                                        <i data-lucide="message-circle" style="width: 18px; height: 18px;"></i>
                                        <span>Hubungi WA WALHI Jabar (+62-82-1982-1159)</span>
                                    </a>
                                </div>
                            </div>

                            <h2 style="margin: 0; font-family: Aspekta, sans-serif; font-weight: 800; font-size: 32px; letter-spacing: 1px; text-transform: uppercase; text-align: center; color: #1D1D1D;">
                                FORMULIR DONASI
                            </h2>
                            
                            <form id="donation-form" onsubmit="handleDonationSubmit(event)" style="display: flex; flex-direction: column; gap: 32px; width: 100%;">
                                <!-- Select Amount Presets -->
                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <label style="color: #1D1D1D; font-family: Montserrat, sans-serif; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.35px;">
                                        Pilih Jumlah Donasi
                                    </label>
                                    
                                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; width: 100%;" class="amount-grid">
                                        <button type="button" class="amount-btn" onclick="selectPresetAmount(10000, this)" style="height: 60px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 16px;">Rp 10.000</button>
                                        <button type="button" class="amount-btn" onclick="selectPresetAmount(25000, this)" style="height: 60px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 16px;">Rp 25000</button>
                                        <button type="button" class="amount-btn" onclick="selectPresetAmount(30000, this)" style="height: 60px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 16px;">Rp 30.000</button>
                                        <button type="button" class="amount-btn" onclick="selectPresetAmount(50000, this)" style="height: 60px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 16px;">Rp 50.000</button>
                                        <button type="button" class="amount-btn" onclick="selectPresetAmount(100000, this)" style="height: 60px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 16px;">Rp 100.000</button>
                                        <button type="button" class="amount-btn" onclick="selectPresetAmount(150000, this)" style="height: 60px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 16px;">Rp 150.000</button>
                                    </div>
                                    
                                    <!-- Custom Amount Field -->
                                    <div style="position: relative; width: 100%;">
                                        <input type="number" id="custom-amount" placeholder="Atau masukkan nominal lain" autocomplete="off" oninput="handleCustomAmountInput(this)" class="input-field" required />
                                    </div>
                                </div>
                                
                                <!-- Personal Info Form -->
                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <label style="color: #1D1D1D; font-family: Montserrat, sans-serif; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.35px;">
                                        Informasi Donatur
                                    </label>
                                    <input type="text" id="donor-name" placeholder="Nama Lengkap" autocomplete="name" class="input-field" required />
                                    <input type="email" id="donor-email" placeholder="Email" autocomplete="email" class="input-field" required />
                                    <input type="tel" id="donor-phone" placeholder="Nomor Telepon / WhatsApp" autocomplete="tel" class="input-field" required />
                                </div>
                                
                                <!-- Transparency Notice -->
                                <div style="background: #F4F1EA; border-left: 4px solid #256D4A; padding: 24px; display: flex; gap: 16px; box-sizing: border-box; align-items: flex-start;">
                                    <i data-lucide="shield-check" style="width: 24px; height: 24px; color: #256D4A; flex-shrink: 0;"></i>
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        <h4 style="margin: 0; color: #1D1D1D; font-family: Montserrat, sans-serif; font-size: 16px; font-weight: 700; line-height: 1.2;">
                                            Transparansi Penggunaan Dana
                                        </h4>
                                        <p style="margin: 0; color: #1D1D1D; font-family: Montserrat, sans-serif; font-size: 15px; line-height: 1.6;">
                                            Kami berkomitmen pada transparansi penuh. Laporan keuangan tahunan dipublikasikan dan dapat diakses oleh publik. Setiap donatur akan menerima laporan penggunaan dana secara berkala.
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons: Online Gateway & Direct WhatsApp -->
                                <div style="display: flex; flex-direction: column; gap: 12px; width: 100%;">
                                    <button type="submit" style="height: 60px; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 16px; letter-spacing: 0.45px; text-transform: uppercase; display: flex; align-items: center; justify-content: center; gap: 8px;" class="submit-btn">
                                        <i data-lucide="credit-card" style="width: 20px; height: 20px;"></i>
                                        Lanjutkan ke Pembayaran
                                    </button>
                                    <button type="button" onclick="donateViaWhatsApp()" style="height: 52px; background: #256D4A; color: white; border: 2px solid #1D1D1D; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 15px; letter-spacing: 0.45px; text-transform: uppercase; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#1f5a3d'" onmouseout="this.style.background='#256D4A'">
                                        <i data-lucide="message-circle" style="width: 20px; height: 20px;"></i>
                                        Konfirmasi Donasi via WhatsApp
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </main>
            @include('partials.site-footer')
        </div>

        <!-- Premium Confirmation Redirection Modal -->
        <div id="payment-modal" style="position: fixed; inset: 0; background: rgba(0, 0, 0, 0.6); z-index: 1000; backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; padding: 16px; box-sizing: border-box;">
            <div style="background: white; border: 4px solid #1D1D1D; width: 100%; max-width: 500px; padding: 40px; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); box-sizing: border-box;">
                
                <div style="width: 80px; height: 80px; background: #256D4A; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                    <i data-lucide="check" style="width: 40px; height: 40px;"></i>
                </div>
                
                <div>
                    <h3 style="margin: 0; font-family: Aspekta, sans-serif; font-weight: 800; font-size: 26px; letter-spacing: 0.5px; color: #1D1D1D; text-transform: uppercase;">
                        Konfirmasi Pembayaran
                    </h3>
                    <p style="margin: 8px 0 0; font-family: Montserrat, sans-serif; font-size: 15px; color: #555; line-height: 1.6;">
                        Terima kasih, <strong id="summary-name">Donatur</strong>! Klik Lanjutkan untuk membuka gerbang pembayaran aman kami.
                    </p>
                </div>
                
                <!-- Summary Detail Box -->
                <div style="background: #F4F1EA; border: 2px solid #1D1D1D; width: 100%; padding: 16px; box-sizing: border-box; display: flex; flex-direction: column; gap: 8px; text-align: left; font-family: Montserrat, sans-serif; font-size: 14px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Nominal:</span>
                        <strong style="color: #256D4A;" id="summary-amount">Rp 0</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Email:</span>
                        <span style="color: #1D1D1D; font-weight: 600;" id="summary-email">email@example.com</span>
                    </div>
                </div>
                
                <div style="display: flex; gap: 12px; width: 100%;">
                    <button onclick="closePaymentModal()" style="flex: 1; height: 48px; background: white; color: #1D1D1D; border: 2px solid #1D1D1D; font-family: Aspekta, sans-serif; font-weight: 700; font-size: 14px; text-transform: uppercase; cursor: pointer;">
                        Batal
                    </button>
                    <button id="confirm-btn" onclick="confirmRedirection()" style="flex: 1; height: 48px; background: #D95C3F; color: #F4F1EA; border: none; font-family: Aspekta, sans-serif; font-weight: 700; font-size: 14px; text-transform: uppercase; cursor: pointer;">
                        Lanjutkan
                    </button>
                </div>
            </div>
        </div>

        @if(Route::has('donasi.mock-payment-status'))
        <!-- Mock Payment Simulator Modal (Local & Testing only) -->
        <div id="mock-payment-modal" style="position: fixed; inset: 0; background: rgba(0, 0, 0, 0.6); z-index: 1001; backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; padding: 16px; box-sizing: border-box;">
            <div style="background: white; border: 4px solid #1D1D1D; width: 100%; max-width: 500px; padding: 40px; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); box-sizing: border-box;">
                <div style="width: 80px; height: 80px; background: #8B6B4A; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                    <i data-lucide="cpu" style="width: 40px; height: 40px;"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-family: Aspekta, sans-serif; font-weight: 800; font-size: 26px; letter-spacing: 0.5px; color: #1D1D1D; text-transform: uppercase;">
                        Simulasi Pembayaran (Mock)
                    </h3>
                    <p style="margin: 8px 0 0; font-family: Montserrat, sans-serif; font-size: 15px; color: #555; line-height: 1.6;">
                        Sistem mendeteksi server berjalan tanpa API key Midtrans. Pilih status pembayaran untuk disimulasikan:
                    </p>
                </div>
                <div style="background: #F4F1EA; border: 2px solid #1D1D1D; width: 100%; padding: 16px; box-sizing: border-box; display: flex; flex-direction: column; gap: 8px; text-align: left; font-family: Montserrat, sans-serif; font-size: 14px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">ID Order:</span>
                        <strong id="mock-summary-id" style="color: #1D1D1D;">WALHI-DON-XXX</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Donatur:</span>
                        <span id="mock-summary-name" style="color: #1D1D1D; font-weight: 600;">Nama</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Nominal:</span>
                        <strong id="mock-summary-amount" style="color: #256D4A;">Rp 0</strong>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px; width: 100%;">
                    <button onclick="submitMockPayment('success')" style="width: 100%; height: 48px; background: #256D4A; color: #F4F1EA; border: none; font-family: Aspekta, sans-serif; font-weight: 700; font-size: 14px; text-transform: uppercase; cursor: pointer;">
                        Simulasikan Sukses
                    </button>
                    <button onclick="submitMockPayment('failed')" style="width: 100%; height: 48px; background: #D95C3F; color: #F4F1EA; border: none; font-family: Aspekta, sans-serif; font-weight: 700; font-size: 14px; text-transform: uppercase; cursor: pointer;">
                        Simulasikan Gagal
                    </button>
                    <button onclick="closeMockPaymentModal()" style="width: 100%; height: 48px; background: white; color: #1D1D1D; border: 2px solid #1D1D1D; font-family: Aspekta, sans-serif; font-weight: 700; font-size: 14px; text-transform: uppercase; cursor: pointer;">
                        Batal
                    </button>
                </div>
            </div>
        </div>
        @endif
        
        <script nonce="{{ Vite::cspNonce() }}">
            var activeOrderId = '';
            var activeSnapToken = '';
            var activeIsMock = false;

            // Select Preset Amount
            function selectPresetAmount(amount, buttonElement) {
                // Clear active states on all buttons
                var buttons = document.getElementsByClassName('amount-btn');
                for (var i = 0; i < buttons.length; i++) {
                    buttons[i].classList.remove('active');
                }
                
                // Set active class on clicked button
                buttonElement.classList.add('active');
                
                // Populate custom amount field and trigger validation checks
                var customInput = document.getElementById('custom-amount');
                customInput.value = amount;
            }
            
            // Custom Amount Input Handler
            function handleCustomAmountInput(inputElement) {
                // Clear preset button active highlights if custom typing occurs
                var buttons = document.getElementsByClassName('amount-btn');
                var val = parseInt(inputElement.value);
                
                for (var i = 0; i < buttons.length; i++) {
                    buttons[i].classList.remove('active');
                    // Check if value matches preset to keep button highlighted
                    var btnText = buttons[i].textContent.replace('Rp ', '').replace(/\./g, '');
                    if (val === parseInt(btnText)) {
                        buttons[i].classList.add('active');
                    }
                }
            }
            
            // Format Currency
            function formatRupiah(amount) {
                return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
            }
            
            // Direct WhatsApp Donation Handler
            function donateViaWhatsApp() {
                var nameInput = document.getElementById('donor-name');
                var amountInput = document.getElementById('custom-amount');
                var phoneInput = document.getElementById('donor-phone');
                
                var name = (nameInput && nameInput.value) ? nameInput.value.trim() : 'Sahabat WALHI';
                var amount = (amountInput && amountInput.value) ? amountInput.value.trim() : '';
                var phone = (phoneInput && phoneInput.value) ? phoneInput.value.trim() : '';
                
                var nominalText = amount ? formatRupiah(amount) : 'sukarela';
                var message = "Halo WALHI Jawa Barat,\n\nSaya " + name + (phone ? " (" + phone + ")" : "") + " ingin berdonasi sebesar " + nominalText + " untuk gerakan lingkungan hidup di Jawa Barat.\n\nMohon informasi rekening resmi WALHI Jawa Barat dan manfaat apa saja yang akan saya terima. Terima kasih :)";
                
                var url = "https://wa.me/6282119821159?text=" + encodeURIComponent(message);
                window.open(url, '_blank');
            }
            
            // Handle Submit Form
            function handleDonationSubmit(event) {
                event.preventDefault();
                
                var name = document.getElementById('donor-name').value;
                var email = document.getElementById('donor-email').value;
                var amount = document.getElementById('custom-amount').value;
                
                // Populate summary texts
                document.getElementById('summary-name').textContent = name;
                document.getElementById('summary-email').textContent = email;
                document.getElementById('summary-amount').textContent = formatRupiah(amount);
                
                // Show modal
                document.getElementById('payment-modal').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
            
            // Close payment modal
            function closePaymentModal() {
                document.getElementById('payment-modal').style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            // Close mock payment modal
            function closeMockPaymentModal() {
                document.getElementById('mock-payment-modal').style.display = 'none';
                document.body.style.overflow = 'auto';
            }
            
            // Confirm redirection and fetch Snap Token
            function confirmRedirection() {
                var name = document.getElementById('donor-name').value;
                var email = document.getElementById('donor-email').value;
                var phone = document.getElementById('donor-phone').value;
                var amount = document.getElementById('custom-amount').value;
                var confirmBtn = document.getElementById('confirm-btn');

                confirmBtn.disabled = true;
                confirmBtn.textContent = 'Memproses...';

                // Fetch CSRF Token from meta
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('{{ route('donasi.pay') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        donor_name: name,
                        donor_email: email,
                        donor_phone: phone,
                        amount: parseInt(amount)
                    })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = 'Lanjutkan';
                    closePaymentModal();

                    if (data.success) {
                        activeOrderId = data.order_id;
                        activeSnapToken = data.snap_token;
                        activeIsMock = data.is_mock;

                        if (activeIsMock) {
                            // Open Simulator modal
                            document.getElementById('mock-summary-id').textContent = activeOrderId;
                            document.getElementById('mock-summary-name').textContent = name;
                            document.getElementById('mock-summary-amount').textContent = formatRupiah(amount);
                            document.getElementById('mock-payment-modal').style.display = 'flex';
                            document.body.style.overflow = 'hidden';
                        } else {
                            // Trigger Midtrans Snap
                            window.snap.pay(activeSnapToken, {
                                onSuccess: function(result) {
                                    alert('Donasi berhasil diproses! Terima kasih banyak atas dukungan Anda.');
                                    location.reload();
                                },
                                onPending: function(result) {
                                    alert('Transaksi pending. Selesaikan pembayaran Anda sesuai instruksi Midtrans.');
                                    location.reload();
                                },
                                onError: function(result) {
                                    alert('Pembayaran gagal atau dibatalkan.');
                                },
                                onClose: function() {
                                    alert('Popup pembayaran ditutup.');
                                }
                            });
                        }
                    } else {
                        alert('Gagal memproses transaksi donasi. Silakan coba lagi.');
                    }
                })
                .catch(function(err) {
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = 'Lanjutkan';
                    console.error(err);
                    alert('Terjadi kesalahan jaringan.');
                });
            }

            @if(Route::has('donasi.mock-payment-status'))
            // Submit mock payment status (Local & Testing only)
            function submitMockPayment(status) {
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('{{ route('donasi.mock-payment-status') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        order_id: activeOrderId,
                        status: status
                    })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    closeMockPaymentModal();
                    if (data.success) {
                        if (status === 'success') {
                            alert('Simulasi donasi sukses berhasil dilakukan! Terima kasih.');
                        } else {
                            alert('Simulasi donasi gagal berhasil dilakukan.');
                        }
                        location.reload();
                    }
                })
                .catch(function(err) {
                    console.error(err);
                    alert('Gagal mengirimkan status simulasi.');
                });
            }
            @endif
            
            // Initialize Lucide icons on page load
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof lucide !== 'undefined' && lucide.createIcons) {
                    lucide.createIcons();
                }
            });
        </script>
    </body>
</html>
