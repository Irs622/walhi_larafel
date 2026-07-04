<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Donasi Publik - WALHI Jawa Barat</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Lucide Script for Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>
        
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
                font-family: Inter, sans-serif;
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
    <body style="width: 100%; background: #F4F1EA; margin: 0; overflow-x: hidden; color: #1D1D1D; font-family: Inter, sans-serif;">
        <div style="position: relative; width: 100%; overflow: hidden; background: #F4F1EA;">
            @include('partials.site-header')

            <main style="display: flex; flex-direction: column; align-items: stretch;">
                
                <!-- Hero Section -->
                <section style="background: #1D1D1D; border-bottom: 4px #256D4A solid; padding: 64px 95px 64px; color: #F4F1EA;">
                    <div style="width: 100%; max-width: 1280px; margin: 0 auto; padding: 0 32px; box-sizing: border-box;">
                        <div style="display: flex; flex-direction: column; gap: 24px; max-width: 860px; width: 100%;">
                            <!-- Breadcrumbs -->
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-family: Inter, sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px;">
                                <a href="{{ route('home') }}" style="color: #F4F1EA; text-decoration: none; opacity: 0.8;">Beranda</a>
                                <span style="color: #256D4A; font-weight: 400; font-size: 16px;">/</span>
                                <span style="color: #F4F1EA; opacity: 0.8;">Dukung Kami</span>
                                <span style="color: #256D4A; font-weight: 400; font-size: 16px;">/</span>
                                <span style="color: #5C8D59;">Donasi Publik</span>
                            </div>
                            
                            <h1 style="margin: 0; color: #F4F1EA; font-size: clamp(52px, 7vw, 80px); font-family: Anton, sans-serif; font-weight: 400; line-height: 0.95; letter-spacing: 1.6px; text-transform: uppercase;">
                                DONASI PUBLIK
                            </h1>
                            <div style="width: 128px; height: 8px; background: #D95C3F;"></div>
                            <p style="margin: 0; color: #5C8D59; font-size: 20px; line-height: 32px; font-family: Inter, sans-serif;">
                                Dukung Perjuangan Keadilan Ekologis
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Why Donate Section -->
                <section style="padding: 80px 95px 80px; background: #F4F1EA; color: #1D1D1D;">
                    <div style="width: 100%; max-width: 1088px; margin: 0 auto; padding: 0 32px; box-sizing: border-box; display: flex; flex-direction: column; gap: 48px;">
                        
                        <!-- Green Callout Block -->
                        <div style="background: #256D4A; border: 4px solid #256D4A; outline: 4px #256D4A solid; outline-offset: -4px; padding: 52px; display: flex; flex-direction: column; align-items: center; gap: 36px; box-sizing: border-box; color: #F4F1EA;" class="why-donate-section">
                            <div style="text-align: center; max-width: 720px; display: flex; flex-direction: column; gap: 16px;">
                                <h2 style="margin: 0; font-family: Anton, sans-serif; font-size: clamp(36px, 5vw, 48px); font-weight: 400; text-transform: uppercase; letter-spacing: 1px; line-height: 1.2;">
                                    MENGAPA DONASI KE WALHI?
                                </h2>
                                <p style="margin: 0; font-family: Inter, sans-serif; font-size: 18px; line-height: 1.7; opacity: 0.95;">
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
                                    <h3 style="margin: 0; font-family: 'Bebas Neue', sans-serif; font-size: 24px; letter-spacing: 1.2px; text-transform: uppercase;">Pendampingan Rakyat</h3>
                                    <p style="margin: 0; font-family: Inter, sans-serif; font-size: 14px; line-height: 1.6; color: #555;">
                                        Donasi membantu kami mendampingi komunitas yang terdampak kerusakan lingkungan, memberikan bantuan hukum dan advokasi.
                                    </p>
                                </div>
                                
                                <!-- Pillar 2 -->
                                <div style="background: white; border: 4px solid white; outline: 4px #F4F1EA solid; outline-offset: -4px; padding: 32px; display: flex; flex-direction: column; align-items: center; gap: 16px; box-sizing: border-box; color: #1D1D1D; text-align: center;" class="hover-pillar-card">
                                    <div style="width: 72px; height: 72px; background: #1D1D1D; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #5C8D59;">
                                        <i data-lucide="bar-chart-3" style="width: 32px; height: 32px;"></i>
                                    </div>
                                    <h3 style="margin: 0; font-family: 'Bebas Neue', sans-serif; font-size: 24px; letter-spacing: 1.2px; text-transform: uppercase;">Investigasi & Riset</h3>
                                    <p style="margin: 0; font-family: Inter, sans-serif; font-size: 14px; line-height: 1.6; color: #555;">
                                        Dana untuk investigasi mendalam kerusakan lingkungan, pengumpulan data, dan produksi laporan berkualitas.
                                    </p>
                                </div>
                                
                                <!-- Pillar 3 -->
                                <div style="background: white; border: 4px solid white; outline: 4px #F4F1EA solid; outline-offset: -4px; padding: 32px; display: flex; flex-direction: column; align-items: center; gap: 16px; box-sizing: border-box; color: #1D1D1D; text-align: center;" class="hover-pillar-card">
                                    <div style="width: 72px; height: 72px; background: #1D1D1D; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #8B6B4A;">
                                        <i data-lucide="megaphone" style="width: 32px; height: 32px;"></i>
                                    </div>
                                    <h3 style="margin: 0; font-family: 'Bebas Neue', sans-serif; font-size: 24px; letter-spacing: 1.2px; text-transform: uppercase;">Kampanye Publik</h3>
                                    <p style="margin: 0; font-family: Inter, sans-serif; font-size: 14px; line-height: 1.6; color: #555;">
                                        Membiayai kampanye kesadaran lingkungan, aksi lapangan, dan gerakan massa untuk perubahan kebijakan.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Donation Form Block -->
                        <div style="background: white; border: 4px solid #1D1D1D; outline: 4px #1D1D1D solid; outline-offset: -4px; padding: 52px 96px; display: flex; flex-direction: column; gap: 32px; box-sizing: border-box;" class="form-outer-container">
                            <h2 style="margin: 0; font-family: 'Bebas Neue', sans-serif; font-size: 40px; letter-spacing: 2px; text-transform: uppercase; text-align: center; color: #1D1D1D;">
                                Form Donasi
                            </h2>
                            
                            <form id="donation-form" onsubmit="handleDonationSubmit(event)" style="display: flex; flex-direction: column; gap: 32px; width: 100%;">
                                <!-- Select Amount Presets -->
                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <label style="color: #1D1D1D; font-family: Inter, sans-serif; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.35px;">
                                        Pilih Jumlah Donasi
                                    </label>
                                    
                                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; width: 100%;" class="amount-grid">
                                        <button type="button" class="amount-btn" onclick="selectPresetAmount(100000, this)" style="height: 60px; font-family: Inter, sans-serif; font-weight: 700; font-size: 16px;">Rp 100.000</button>
                                        <button type="button" class="amount-btn" onclick="selectPresetAmount(250000, this)" style="height: 60px; font-family: Inter, sans-serif; font-weight: 700; font-size: 16px;">Rp 250.000</button>
                                        <button type="button" class="amount-btn" onclick="selectPresetAmount(500000, this)" style="height: 60px; font-family: Inter, sans-serif; font-weight: 700; font-size: 16px;">Rp 500.000</button>
                                        <button type="button" class="amount-btn" onclick="selectPresetAmount(1000000, this)" style="height: 60px; font-family: Inter, sans-serif; font-weight: 700; font-size: 16px;">Rp 1.000.000</button>
                                        <button type="button" class="amount-btn" onclick="selectPresetAmount(2500000, this)" style="height: 60px; font-family: Inter, sans-serif; font-weight: 700; font-size: 16px;">Rp 2.500.000</button>
                                        <button type="button" class="amount-btn" onclick="selectPresetAmount(5000000, this)" style="height: 60px; font-family: Inter, sans-serif; font-weight: 700; font-size: 16px;">Rp 5.000.000</button>
                                    </div>
                                    
                                    <!-- Custom Amount Field -->
                                    <div style="position: relative; width: 100%;">
                                        <input type="number" id="custom-amount" placeholder="Atau masukkan nominal lain" oninput="handleCustomAmountInput(this)" class="input-field" required />
                                    </div>
                                </div>
                                
                                <!-- Personal Info Form -->
                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <label style="color: #1D1D1D; font-family: Inter, sans-serif; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.35px;">
                                        Informasi Donatur
                                    </label>
                                    <input type="text" id="donor-name" placeholder="Nama Lengkap" class="input-field" required />
                                    <input type="email" id="donor-email" placeholder="Email" class="input-field" required />
                                    <input type="tel" id="donor-phone" placeholder="Nomor Telepon" class="input-field" required />
                                </div>
                                
                                <!-- Transparency Notice -->
                                <div style="background: #F4F1EA; border-left: 4px solid #256D4A; padding: 24px; display: flex; gap: 16px; box-sizing: border-box; align-items: flex-start;">
                                    <i data-lucide="shield-check" style="width: 24px; height: 24px; color: #256D4A; flex-shrink: 0;"></i>
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        <h4 style="margin: 0; color: #1D1D1D; font-family: Inter, sans-serif; font-size: 16px; font-weight: 700; line-height: 1.2;">
                                            Transparansi Penggunaan Dana
                                        </h4>
                                        <p style="margin: 0; color: #1D1D1D; font-family: Inter, sans-serif; font-size: 15px; line-height: 1.6;">
                                            Kami berkomitmen pada transparansi penuh. Laporan keuangan tahunan dipublikasikan dan dapat diakses oleh publik. Setiap donatur akan menerima laporan penggunaan dana secara berkala.
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Submit Trigger Button -->
                                <button type="submit" style="height: 60px; font-family: Inter, sans-serif; font-weight: 700; font-size: 16px; letter-spacing: 0.45px; text-transform: uppercase; display: flex; align-items: center; justify-content: center; gap: 8px;" class="submit-btn">
                                    <i data-lucide="credit-card" style="width: 20px; height: 20px;"></i>
                                    Lanjutkan ke Pembayaran
                                </button>
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
                    <h3 style="margin: 0; font-family: 'Bebas Neue', sans-serif; font-size: 32px; letter-spacing: 1px; color: #1D1D1D;">
                        Konfirmasi Pembayaran
                    </h3>
                    <p style="margin: 8px 0 0; font-family: Inter, sans-serif; font-size: 15px; color: #555; line-height: 1.6;">
                        Terima kasih, <strong id="summary-name">Donatur</strong>! Anda akan diarahkan ke gerbang pembayaran aman kami.
                    </p>
                </div>
                
                <!-- Summary Detail Box -->
                <div style="background: #F4F1EA; border: 2px solid #1D1D1D; width: 100%; padding: 16px; box-sizing: border-box; display: flex; flex-direction: column; gap: 8px; text-align: left; font-family: Inter, sans-serif; font-size: 14px;">
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
                    <button onclick="closePaymentModal()" style="flex: 1; height: 48px; background: white; color: #1D1D1D; border: 2px solid #1D1D1D; font-family: Inter, sans-serif; font-weight: 700; font-size: 14px; text-transform: uppercase; cursor: pointer;">
                        Batal
                    </button>
                    <button onclick="confirmRedirection()" style="flex: 1; height: 48px; background: #D95C3F; color: #F4F1EA; border: none; font-family: Inter, sans-serif; font-weight: 700; font-size: 14px; text-transform: uppercase; cursor: pointer;">
                        Lanjutkan
                    </button>
                </div>
            </div>
        </div>
        
        <script>
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
                
                var matched = false;
                for (var i = 0; i < buttons.length; i++) {
                    buttons[i].classList.remove('active');
                    // Check if value matches preset to keep button highlighted
                    var btnText = buttons[i].textContent.replace('Rp ', '').replace(/\./g, '');
                    if (val === parseInt(btnText)) {
                        buttons[i].classList.add('active');
                        matched = true;
                    }
                }
            }
            
            // Format Currency
            function formatRupiah(amount) {
                return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
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
            
            // Mock confirm redirect
            function confirmRedirection() {
                alert('Mengarahkan ke Gerbang Pembayaran Mandiri/VA/Qris...');
                closePaymentModal();
                document.getElementById('donation-form').reset();
                var buttons = document.getElementsByClassName('amount-btn');
                for (var i = 0; i < buttons.length; i++) {
                    buttons[i].classList.remove('active');
                }
            }
            
            // Initialize Lucide icons on page load
            document.addEventListener('DOMContentLoaded', function() {
                lucide.createIcons();
            });
        </script>
    </body>
</html>
