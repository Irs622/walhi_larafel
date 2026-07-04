<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tentang Kami - WALHI Jawa Barat</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="width: 100%; background: #F4F1EA; margin: 0; overflow-x: hidden; color: #1D1D1D; font-family: Inter, sans-serif;">
        <div style="position: relative; width: 100%; height: calc(3572.13px * var(--canvas-scale, 1)); overflow: hidden; background: #F4F1EA;">
            <div style="position: absolute; left: 0; top: 0; width: 1470px; height: 3572.13px; transform: scale(var(--canvas-scale, 1)); transform-origin: top left;">
                @include('partials.site-header')

                <div style="width: 100%; height: 3572.13px; display: flex; flex-direction: column; align-items: flex-start;">
                <div style="align-self: stretch; height: 336px; padding-top: 64px; padding-bottom: 4px; padding-left: 95px; padding-right: 95px; background: #1D1D1D; border-bottom: 4px #256D4A solid; display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;">
                    <div style="align-self: stretch; height: 204px; position: relative;">
                        <div style="width: 1216px; height: 24px; left: 32px; top: 0; position: absolute; display: inline-flex; align-items: center; gap: 8px;">
                            <div style="width: 73.64px; height: 24px; display: flex; align-items: center; gap: 8px;">
                                <div style="flex: 1 1 0; height: 18px; position: relative;"><div style="left: 0; top: 0.5px; position: absolute; color: #F4F1EA; font-size: 12px; font-weight: 600; text-transform: uppercase; line-height: 18px; letter-spacing: 0.30px;">Beranda</div></div>
                                <div style="width: 5.77px; height: 24px; position: relative;"><div style="left: 0; top: -1px; position: absolute; color: #256D4A; font-size: 16px; font-weight: 400; line-height: 24px;">/</div></div>
                            </div>
                            <div style="width: 109.95px; height: 24px; display: flex; align-items: center; gap: 8px;">
                                <div style="flex: 1 1 0; height: 18px; position: relative;"><div style="left: 0; top: 0.5px; position: absolute; color: #F4F1EA; font-size: 12px; font-weight: 600; text-transform: uppercase; line-height: 18px; letter-spacing: 0.30px;">Tentang Kami</div></div>
                                <div style="width: 5.77px; height: 24px; position: relative;"><div style="left: 0; top: -1px; position: absolute; color: #256D4A; font-size: 16px; font-weight: 400; line-height: 24px;">/</div></div>
                            </div>
                            <div style="width: 84.67px; height: 18px; position: relative;"><div style="left: 0; top: 0.5px; position: absolute; color: #5C8D59; font-size: 12px; font-weight: 600; text-transform: uppercase; line-height: 18px; letter-spacing: 0.30px;">Visi dan Misi</div></div>
                        </div>
                        <div style="width: 1216px; height: 76px; left: 32px; top: 48px; position: absolute;"><div style="left: 0; top: -0.5px; position: absolute; color: #F4F1EA; font-size: 80px; font-family: Anton, sans-serif; font-weight: 400; text-transform: uppercase; line-height: 76px; letter-spacing: 1.60px;">VISI &amp; MISI</div></div>
                        <div style="width: 1216px; height: 32px; left: 32px; top: 140px; position: absolute;"><div style="left: 0; top: -0.5px; position: absolute; color: #5C8D59; font-size: 20px; font-weight: 400; line-height: 32px;">Landasan Perjuangan WALHI Jawa Barat</div></div>
                        <div style="width: 128px; height: 8px; left: 32px; top: 196px; position: absolute; background: #D95C3F;"></div>
                    </div>
                </div>

                <div style="align-self: stretch; height: 2426.13px; padding-top: 80px; padding-left: 159px; padding-right: 159px; background: #F4F1EA; display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;">
                    <div style="align-self: stretch; height: 2266.13px; padding-left: 32px; padding-right: 32px; display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 48px;">
                        @php
                            $missionItems = [
                                'Mengorganisir masyarakat sipil, petani, nelayan, masyarakat adat, dan kelompok rentan lainnya dalam memperjuangkan hak atas lingkungan hidup yang sehat dan berkelanjutan.',
                                'Melakukan advokasi kebijakan, riset, pendidikan kritis, dan kampanye publik untuk menghentikan praktik perusakan lingkungan dan perampasan ruang hidup.',
                                'Memperkuat solidaritas lintas wilayah dan membangun gerakan bersama yang berakar pada pengalaman perjuangan rakyat di Jawa Barat.',
                                'Mendorong praktik hidup dan tata kelola sumber daya alam yang adil, demokratis, dan berpihak pada keberlanjutan ekologis.',
                            ];
                        @endphp
                        <div style="align-self: stretch; height: 517.78px; position: relative; background: #256D4A; outline: 4px #256D4A solid; outline-offset: -4px;">
                            <div style="width: 106.59px; height: 37px; left: 490.70px; top: 52px; position: absolute; background: #1D1D1D;"><div style="left: 16px; top: 8px; position: absolute; text-align: center; color: #5C8D59; font-size: 14px; font-weight: 700; text-transform: uppercase; line-height: 21px; letter-spacing: 0.70px;">Visi Kami</div></div>
                            <div style="width: 984px; height: 184.78px; left: 52px; top: 113px; position: absolute;"><div style="left: 120.89px; top: -0.5px; position: absolute; text-align: center; color: #F4F1EA; font-size: 56px; font-family: Anton, sans-serif; font-weight: 400; text-transform: uppercase; line-height: 61.6px; letter-spacing: 1.12px;">TERWUJUDNYA KEADILAN EKOLOGIS<br> DAN KEDAULATAN RAKYAT<br> ATAS SUMBER DAYA ALAM</div></div>
                            <div style="width: 896px; height: 136px; left: 96px; top: 329.78px; position: absolute;"><div style="width: 896px; left: 0; top: -0.5px; position: absolute; text-align: center; color: #F4F1EA; font-size: 20px; font-weight: 400; line-height: 34px;">Kami membayangkan Jawa Barat di mana masyarakat memiliki kontrol penuh atas sumber daya alam di wilayah mereka, di mana lingkungan hidup dilindungi bukan untuk profit tetapi untuk kehidupan, dan di mana keputusan tentang alam dibuat oleh rakyat yang hidupnya bergantung padanya — bukan oleh korporasi atau elite politik.</div></div>
                        </div>

                        <div style="align-self: stretch; height: 923.38px; padding-top: 52px; padding-bottom: 4px; padding-left: 52px; padding-right: 52px; background: white; outline: 4px #1D1D1D solid; outline-offset: -4px; position: relative; display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 48px;">
                            <div style="align-self: stretch; height: 121px; position: relative;">
                                <div style="width: 109.19px; height: 37px; left: 437.41px; top: 0; position: absolute; background: #D95C3F;"><div style="left: 17px; top: 8px; position: absolute; text-align: center; color: #F4F1EA; font-size: 14px; font-weight: 700; text-transform: uppercase; line-height: 21px; letter-spacing: 0.70px;">Misi Kami</div></div>
                                <div style="width: 984px; height: 60px; left: 0; top: 61px; position: absolute;"><div style="left: 271.90px; top: 0; position: absolute; text-align: center; color: #1D1D1D; font-size: 40px; font-family: Bebas Neue, sans-serif; font-weight: 400; text-transform: uppercase; line-height: 60px; letter-spacing: 2px;">Langkah Konkret Perjuangan</div></div>
                            </div>
                            <div style="align-self: stretch; height: 650.38px; display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 16px;">
                                @foreach ($missionItems as $index => $mission)
                                    <div style="align-self: stretch; height: {{ $index < 2 ? '109.19px' : '88px' }}; padding: 24px; background: #F4F1EA; border-left: 4px #256D4A solid; display: inline-flex; justify-content: flex-start; align-items: flex-start; gap: 24px;">
                                        <div style="width: 40px; height: 40px; background: #1D1D1D; display: flex; justify-content: center; align-items: center;"><div style="color: #256D4A; font-size: 24px; font-family: Bebas Neue, sans-serif; font-weight: 400; line-height: 36px;">{{ $index + 1 }}</div></div>
                                        <div style="flex: 1 1 0; height: 61.19px; position: relative;"><div style="width: 868px; left: 0; top: 0; position: absolute; color: #1D1D1D; font-size: 18px; font-weight: 400; line-height: 30.6px;">{{ $mission }}</div></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div style="align-self: stretch; height: 728.98px; padding-top: 52px; padding-bottom: 4px; padding-left: 52px; padding-right: 52px; background: #1D1D1D; outline: 4px #1D1D1D solid; outline-offset: -4px; position: relative; display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 48px;">
                            <div style="align-self: stretch; height: 121px; position: relative;">
                                <div style="width: 164.36px; height: 37px; left: 409.82px; top: 0; position: absolute; background: #256D4A;"><div style="left: 17px; top: 8px; position: absolute; text-align: center; color: #F4F1EA; font-size: 14px; font-weight: 700; text-transform: uppercase; line-height: 21px; letter-spacing: 0.70px;">Nilai-Nilai Kami</div></div>
                                <div style="width: 984px; height: 60px; left: 0; top: 61px; position: absolute;"><div style="left: 228.62px; top: 0; position: absolute; text-align: center; color: #F4F1EA; font-size: 40px; font-family: Bebas Neue, sans-serif; font-weight: 400; text-transform: uppercase; line-height: 60px; letter-spacing: 2px;">Prinsip yang Menuntun Perjuangan</div></div>
                            </div>
                            <div style="align-self: stretch; height: 455.98px; position: relative;">
                                <div style="width: 476px; height: 225.59px; padding-top: 36px; padding-bottom: 4px; padding-left: 36px; padding-right: 36px; left: 0; top: 0; position: absolute; background: white; outline: 4px #F4F1EA solid; outline-offset: -4px; display: inline-flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 16px;">
                                    <div style="align-self: stretch; height: 56px; display: inline-flex; justify-content: flex-start; align-items: flex-start; gap: 16px;">
                                        <div style="width: 56px; height: 56px; padding-top: 12px; padding-left: 12px; padding-right: 12px; background: #1D1D1D; display: inline-flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;"><div style="align-self: stretch; height: 32px; position: relative; overflow: hidden;"><div style="width: 24.01px; height: 26.67px; left: 4px; top: 2.66px; position: absolute; outline: 2.67px #256D4A solid; outline-offset: -1.33px;"></div></div></div>
                                        <div style="width: 137.45px; height: 48px; position: relative;"><div style="left: 0; top: -0.5px; position: absolute; color: #1D1D1D; font-size: 32px; font-family: Bebas Neue, sans-serif; font-weight: 400; text-transform: uppercase; line-height: 48px; letter-spacing: 1.6px;">Keberanian</div></div>
                                    </div>
                                    <div style="align-self: stretch; height: 81.59px; position: relative;"><div style="width: 404px; left: 0; top: -0.5px; position: absolute; color: #1D1D1D; font-size: 16px; font-weight: 400; line-height: 27.2px;">Berani mengambil sikap tegas terhadap ketidakadilan ekologis dan menantang kekuasaan yang merusak lingkungan.</div></div>
                                </div>
                                <div style="width: 476px; height: 225.59px; padding-top: 36px; padding-bottom: 4px; padding-left: 36px; padding-right: 36px; left: 508px; top: 0; position: absolute; background: white; outline: 4px #F4F1EA solid; outline-offset: -4px; display: inline-flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 16px;">
                                    <div style="align-self: stretch; height: 56px; display: inline-flex; justify-content: flex-start; align-items: flex-start; gap: 16px;">
                                        <div style="width: 56px; height: 56px; padding-top: 12px; padding-left: 12px; padding-right: 12px; background: #1D1D1D; display: inline-flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;"><div style="align-self: stretch; height: 32px; position: relative; overflow: hidden;"><div style="width: 26.67px; height: 26.67px; left: 2.67px; top: 2.67px; position: absolute; outline: 2.67px #256D4A solid; outline-offset: -1.33px;"></div><div style="width: 16px; height: 16px; left: 8px; top: 8px; position: absolute; outline: 2.67px #256D4A solid; outline-offset: -1.33px;"></div><div style="width: 5.33px; height: 5.33px; left: 13.33px; top: 13.33px; position: absolute; outline: 2.67px #256D4A solid; outline-offset: -1.33px;"></div></div></div>
                                        <div style="width: 71.59px; height: 48px; position: relative;"><div style="left: 0; top: -0.5px; position: absolute; color: #1D1D1D; font-size: 32px; font-family: Bebas Neue, sans-serif; font-weight: 400; text-transform: uppercase; line-height: 48px; letter-spacing: 1.6px;">Kritis</div></div>
                                    </div>
                                    <div style="align-self: stretch; height: 81.59px; position: relative;"><div style="width: 404px; left: 0; top: -0.5px; position: absolute; color: #1D1D1D; font-size: 16px; font-weight: 400; line-height: 27.2px;">Menganalisis akar masalah lingkungan secara mendalam dan tidak menerima solusi yang superfisial.</div></div>
                                </div>
                                <div style="width: 476px; height: 198.39px; padding-top: 36px; padding-bottom: 4px; padding-left: 36px; padding-right: 36px; left: 0; top: 257.59px; position: absolute; background: white; outline: 4px #F4F1EA solid; outline-offset: -4px; display: inline-flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 16px;">
                                    <div style="align-self: stretch; height: 56px; display: inline-flex; justify-content: flex-start; align-items: flex-start; gap: 16px;">
                                        <div style="width: 56px; height: 56px; padding-top: 12px; padding-left: 12px; padding-right: 12px; background: #1D1D1D; display: inline-flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;"><div style="align-self: stretch; height: 32px; position: relative; overflow: hidden;"><div style="width: 11.31px; height: 11.31px; left: 10.35px; top: 10.35px; position: absolute; outline: 2.67px #256D4A solid; outline-offset: -1.33px;"></div><div style="width: 26.67px; height: 26.67px; left: 2.67px; top: 2.67px; position: absolute; outline: 2.67px #256D4A solid; outline-offset: -1.33px;"></div></div></div>
                                        <div style="width: 124.64px; height: 48px; position: relative;"><div style="left: 0; top: -0.5px; position: absolute; color: #1D1D1D; font-size: 32px; font-family: Bebas Neue, sans-serif; font-weight: 400; text-transform: uppercase; line-height: 48px; letter-spacing: 1.6px;">Komunitas</div></div>
                                    </div>
                                    <div style="align-self: stretch; height: 54.39px; position: relative;"><div style="width: 404px; left: 0; top: -0.5px; position: absolute; color: #1D1D1D; font-size: 16px; font-weight: 400; line-height: 27.2px;">Menempatkan masyarakat sebagai subjek perubahan dan memperkuat organisasi rakyat di garis depan.</div></div>
                                </div>
                                <div style="width: 476px; height: 198.39px; padding-top: 36px; padding-bottom: 4px; padding-left: 36px; padding-right: 36px; left: 508px; top: 257.59px; position: absolute; background: white; outline: 4px #F4F1EA solid; outline-offset: -4px; display: inline-flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 16px;">
                                    <div style="align-self: stretch; height: 56px; display: inline-flex; justify-content: flex-start; align-items: flex-start; gap: 16px;">
                                        <div style="width: 56px; height: 56px; padding-top: 12px; padding-left: 12px; padding-right: 12px; background: #1D1D1D; display: inline-flex; flex-direction: column; justify-content: flex-start; align-items: flex-start;"><div style="align-self: stretch; height: 32px; position: relative; overflow: hidden;"><div style="width: 26.67px; height: 18.67px; left: 2.67px; top: 6.67px; position: absolute; outline: 2.67px #256D4A solid; outline-offset: -1.33px;"></div><div style="width: 8px; height: 8px; left: 12px; top: 12px; position: absolute; outline: 2.67px #256D4A solid; outline-offset: -1.33px;"></div></div></div>
                                        <div style="width: 104.2px; height: 48px; position: relative;"><div style="left: 0; top: -0.5px; position: absolute; color: #1D1D1D; font-size: 32px; font-family: Bebas Neue, sans-serif; font-weight: 400; text-transform: uppercase; line-height: 48px; letter-spacing: 1.6px;">Ekologis</div></div>
                                    </div>
                                    <div style="align-self: stretch; height: 54.39px; position: relative;"><div style="width: 404px; left: 0; top: -0.5px; position: absolute; color: #1D1D1D; font-size: 16px; font-weight: 400; line-height: 27.2px;">Memahami bahwa krisis lingkungan terkait erat dengan sistem ekonomi-politik yang eksploitatif.</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    @include('partials.site-footer')
                </div>
            </div>
        </div>
    </body>
</html>
