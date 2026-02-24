<div style="background-color:#f4f6f8;padding:30px 15px;font-family:Arial,sans-serif;">
    <div style="max-width:600px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 15px rgba(0,0,0,0.08);">

        <!-- Header -->
        <div style="background:linear-gradient(135deg,#ff7e5f,#feb47b);padding:25px;text-align:center;color:#ffffff;">
            <h2 style="margin:0;">🎁 Nota Pesanan / Hadiah</h2>
            <p style="margin:5px 0 0 0;font-size:14px;">Terima kasih sudah berbelanja dengan kami!</p>
        </div>

        <div style="padding:25px;">

           <!-- Info Pengirim & Penerima -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:25px;">
                <tr>
                    <!-- Pengirim -->
                    <td width="48%" valign="top" style="background:#f8f9ff;padding:18px;border-radius:10px;">
                        <h4 style="margin:0 0 10px 0;color:#6c63ff;text-align:center;">
                            👤 Pengirim
                        </h4>
                        <p style="margin:0;text-align:center;font-size:15px;">
                            <strong>{{ $user_name }}</strong>
                        </p>
                        <p style="margin:5px 0 0 0;text-align:center;color:#555;">
                            📞 {{ $user_phone }}
                        </p>
                    </td>

                    <td width="4%"></td>

                    <!-- Penerima -->
                    <td width="48%" valign="top" style="background:#fff4f8;padding:18px;border-radius:10px;">
                        <h4 style="margin:0 0 10px 0;color:#e84393;text-align:center;">
                            🎀 Penerima
                        </h4>
                        <p style="margin:0;text-align:center;font-size:15px;">
                            <strong>{{ $receiver_name }}</strong>
                        </p>
                        <p style="margin:5px 0 0 0;text-align:center;color:#555;">
                            📍 {{ $receiver_address }}
                        </p>
                        <p style="margin:5px 0 0 0;text-align:center;color:#555;">
                            📞 {{ $receiver_phone }}
                        </p>
                    </td>
                </tr>
            </table>

            <!-- Status Pesanan -->
            <div style="text-align:center;margin-bottom:25px;">
                <h4 style="margin-bottom:10px;color:#2c3e50;">📦 Status Pesanan</h4>

                <div style="
                    display:inline-block;
                    padding:12px 28px;
                    border-radius:30px;
                    font-size:14px;
                    font-weight:bold;
                    letter-spacing:1px;
                    color:#ffffff;
                    box-shadow:0 4px 10px rgba(0,0,0,0.1);
                    background:
                    @if($status == 'Diproses') linear-gradient(45deg,#f39c12,#f1c40f)
                    @elseif($status == 'Dikirim') linear-gradient(45deg,#3498db,#5dade2)
                    @elseif($status == 'Selesai') linear-gradient(45deg,#27ae60,#58d68d)
                    @else linear-gradient(45deg,#7f8c8d,#95a5a6) @endif;
                ">
                    {{ strtoupper($status) }}
                </div>
            </div>

            <!-- Catatan -->
            @if(!empty($catatan))
            <div style="margin-bottom:20px;background:#fff8e1;padding:15px;border-radius:8px;border-left:4px solid #ffc107;">
                <h4 style="margin:0 0 5px 0;color:#795548;">📝 Catatan</h4>
                <p style="margin:0;color:#555;">{{ $catatan }}</p>
            </div>
            @endif

            <!-- Rincian -->
            <div style="margin-bottom:20px;">
                <h4 style="margin-bottom:10px;color:#2c3e50;">🛍️ Rincian Produk</h4>
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f8f9fa;">
                            <th style="padding:10px;text-align:left;font-size:13px;">Produk</th>
                            <th style="padding:10px;text-align:center;font-size:13px;">Jumlah</th>
                            <th style="padding:10px;text-align:right;font-size:13px;">Harga Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td style="padding:10px;border-bottom:1px solid #eee;">
                                {{ $item->produk->nama_produk }}
                            </td>
                            <td style="padding:10px;text-align:center;border-bottom:1px solid #eee;">
                                {{ $item->jumlah }}
                            </td>
                            <td style="padding:10px;text-align:right;border-bottom:1px solid #eee;">
                                Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="text-align:right;margin-top:15px;">
                    <p style="margin:0;font-size:16px;font-weight:bold;color:#2c3e50;">
                        Total: Rp {{ number_format($total_harga, 0, ',', '.') }}
                    </p>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div style="background:#f8f9fa;padding:20px;text-align:center;font-size:13px;color:#777;">
            <p style="margin:0 0 5px 0;">💖 Terima kasih sudah mempercayakan momen spesialmu kepada kami!</p>
            <p style="margin:0;">
                Jika ada pertanyaan, hubungi kami di
                <a href="mailto:Official.kikibi@gmail.com" style="color:#ff7e5f;text-decoration:none;">
                    Official.kikibi@gmail.com
                </a>
            </p>
        </div>

    </div>
</div>
