<footer class="w-full bg-[#1D1D1D] border-t-4 border-[#F4F1EA] py-12 px-6 sm:px-12 md:px-24 text-[#F4F1EA]">
    <div class="max-w-6xl mx-auto flex flex-col gap-12">
        <!-- Top Section: Grid 3 Kolom -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            <!-- Kolom Brand -->
            <div class="md:col-span-6 flex flex-col gap-6">
                <h3 class="text-3xl font-label tracking-widest text-[#F4F1EA] uppercase">WALHI Jawa Barat</h3>
                <p class="text-sm md:text-base leading-relaxed text-[#F4F1EA]/80 max-w-xl">
                    Wahana Lingkungan Hidup Indonesia (WALHI) Jawa Barat adalah organisasi lingkungan hidup independen yang memperjuangkan keadilan ekologis dan kedaulatan rakyat atas sumber daya alam.
                </p>
                <!-- Icons Media Sosial -->
                <div class="flex gap-4">
                    <!-- Facebook -->
                    <a href="https://facebook.com" target="_blank" class="w-12 h-12 bg-[#256D4A] hover:bg-[#5C8D59] transition-colors flex items-center justify-center text-[#F4F1EA] border-2 border-transparent hover:border-[#1D1D1D]" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <!-- Twitter -->
                    <a href="https://twitter.com" target="_blank" class="w-12 h-12 bg-[#256D4A] hover:bg-[#5C8D59] transition-colors flex items-center justify-center text-[#F4F1EA] border-2 border-transparent hover:border-[#1D1D1D]" aria-label="Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                    </a>
                    <!-- Instagram -->
                    <a href="https://instagram.com" target="_blank" class="w-12 h-12 bg-[#256D4A] hover:bg-[#5C8D59] transition-colors flex items-center justify-center text-[#F4F1EA] border-2 border-transparent hover:border-[#1D1D1D]" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                    </a>
                </div>
            </div>

            <!-- Kolom Navigasi -->
            <div class="md:col-span-3 flex flex-col gap-4">
                <div class="pb-2 border-[#256D4A] border-b-2">
                    <h4 class="text-xl font-label tracking-wider text-[#5C8D59] uppercase">Navigasi</h4>
                </div>
                <ul class="flex flex-col gap-3 text-sm md:text-base text-[#F4F1EA]/80 font-sans">
                    <li><a href="{{ route('about') }}" class="hover:text-[#5C8D59] transition-colors text-decoration-none">Tentang Kami</a></li>
                    <li><a href="{{ route('home') }}#isu" class="hover:text-[#5C8D59] transition-colors text-decoration-none">Isu Lingkungan</a></li>
                    <li><a href="{{ route('home') }}#kabar" class="hover:text-[#5C8D59] transition-colors text-decoration-none">Kampanye</a></li>
                    <li><a href="{{ route('blog') }}" class="hover:text-[#5C8D59] transition-colors text-decoration-none">Berita & Artikel</a></li>
                    <li><a href="{{ route('laporan-tahunan') }}" class="hover:text-[#5C8D59] transition-colors text-decoration-none">Laporan</a></li>
                    <li><a href="{{ route('home') }}" class="hover:text-[#5C8D59] transition-colors text-decoration-none">Kontak</a></li>
                </ul>
            </div>

            <!-- Kolom Jaringan -->
            <div class="md:col-span-3 flex flex-col gap-4">
                <div class="pb-2 border-[#256D4A] border-b-2">
                    <h4 class="text-xl font-label tracking-wider text-[#5C8D59] uppercase">Jaringan</h4>
                </div>
                <ul class="flex flex-col gap-3 text-sm md:text-base text-[#F4F1EA]/80 font-sans">
                    <li><a href="https://www.walhi.or.id" target="_blank" class="hover:text-[#5C8D59] transition-colors text-decoration-none">WALHI Nasional</a></li>
                    <li><a href="https://www.foei.org" target="_blank" class="hover:text-[#5C8D59] transition-colors text-decoration-none">Friends of the Earth</a></li>
                    <li><a href="https://www.greenpeace.org/indonesia" target="_blank" class="hover:text-[#5C8D59] transition-colors text-decoration-none">Greenpeace Indonesia</a></li>
                    <li><a href="https://kpa.or.id" target="_blank" class="hover:text-[#5C8D59] transition-colors text-decoration-none">KPA (Konsorsium Pembaruan Agraria)</a></li>
                    <li><a href="https://www.jatam.org" target="_blank" class="hover:text-[#5C8D59] transition-colors text-decoration-none">JATAM (Jaringan Advokasi Tambang)</a></li>
                </ul>
            </div>
        </div>

        <!-- Middle Section: Langganan Newsletter -->
        <div class="bg-[#256D4A] p-6 md:p-8 flex flex-col md:flex-row justify-between items-center gap-6 border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#F4F1EA]">
            <div class="flex flex-col gap-2 max-w-2xl w-full">
                <h4 class="text-2xl md:text-3xl font-label uppercase tracking-wider text-[#F4F1EA]">Berlangganan Newsletter</h4>
                <p class="text-sm md:text-base text-[#F4F1EA]/90">Dapatkan update terbaru tentang isu lingkungan, kampanye, dan aksi-aksi WALHI Jawa Barat.</p>
            </div>
            <form action="#" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <div class="relative flex-grow sm:w-64">
                    <input type="email" placeholder="Email kamu" class="w-full py-3 pl-12 pr-4 bg-white text-[#1D1D1D] border-2 border-transparent focus:border-[#D95C3F] outline-none font-sans" required />
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#5C8D59] w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                </div>
                <button type="submit" class="bg-[#D95C3F] hover:bg-[#c44e32] transition-colors text-white font-bold uppercase tracking-wider px-8 py-3 whitespace-nowrap font-sans text-sm">Subscribe</button>
            </form>
        </div>

        <!-- Bottom Section: Hak Cipta & Link Tambahan -->
        <div class="border-t-2 border-[#256D4A] pt-6 flex flex-col md:flex-row justify-between items-center gap-4 text-xs md:text-sm text-[#F4F1EA]/80 font-sans">
            <p class="text-center md:text-left">© 2026 WALHI Jawa Barat. Organisasi Independen. Tidak Berafiliasi dengan Korporasi atau Pemerintah.</p>
            <div class="flex gap-6 uppercase tracking-wider font-semibold">
                <a href="#" class="hover:text-[#5C8D59] transition-colors text-decoration-none">Kebijakan Privasi</a>
                <a href="#" class="hover:text-[#5C8D59] transition-colors text-decoration-none">Transparansi Dana</a>
            </div>
        </div>
    </div>
</footer>
