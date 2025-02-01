<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Invoice
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                
                <!-- Invoice Header -->
                <div class="px-6 py-4" style="background-color: #6366f1; color: white;">
                    <h3 class="text-lg font-bold">{{ $inspection->inv_number }}</h3>
                    <div class="flex justify-between mt-2">
                        <div>
                            <p class="text-sm">Nama Pasien : <span class="font-semibold">{{ $inspection->nama_pasien }}</span></p>
                            <p class="text-sm">Tanggal Pemeriksaan : {{ $inspection->tanggal_pemeriksaan }}</p>
                        </div>
                    </div>
                </div>

                <!-- Invoice Table -->
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full border text-sm">
                            <thead style="background-color: #6366f1; color: white;">
                                <tr>
                                    <th class="px-4 py-2 text-left">#</th>
                                    <th class="px-4 py-2 text-left">Nama Obat</th>
                                    <th class="px-4 py-2 text-center">Quantity</th>
                                    <th class="px-4 py-2 text-right">Harga Satuan</th>
                                    <th class="px-4 py-2 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $grandTotal = 0;
                                @endphp
                                @foreach($inspection->medicines as $index => $medicine)
                                    @php
                                        $price = app(\App\Http\Controllers\InspectionController::class)->getMedicinePrice($medicine->id_obat, $inspection->tanggal_pemeriksaan);
                                        $total = $medicine->jumlah * $price;
                                        $grandTotal += $total;
                                    @endphp
                                    <tr class="{{ $loop->odd ? 'bg-gray-100' : '' }}">
                                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2">{{ $medicine->nama_obat }}</td>
                                        <td class="px-4 py-2 text-center">{{ $medicine->jumlah }}</td>
                                        <td class="px-4 py-2 text-right">Rp {{ number_format($price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Total Section -->
                    <div class="mt-6 text-right">
                        <div class="flex justify-between border-t border-gray-300 pt-4">
                            <span class="font-bold">Total</span>
                            <span class="font-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mt-2 text-lg font-bold">
                            <span>Jumlah Bayar</span>
                            <input type="text" id="total_bayar" class="border rounded-md w-48 text-right" placeholder="Masukkan jumlah">
                        </div>
                    </div>

                    <!-- Confirmation Button -->
                    <div class="mt-6 text-center">
                        <form id="invoice-form" method="POST" action="{{ route('invoices.pay') }}">
                            @csrf
                            <input type="hidden" name="id_inspection" value="{{ $inspection->id }}">
                            <input type="hidden" name="total_harga" value="{{ $grandTotal }}">
                            <input type="hidden" name="total_bayar" id="hidden_total_bayar" value="">
                            <button type="button" onclick="confirmPayment()" class="px-6 py-2 rounded-md text-white" style="background-color: #6366f1; hover:bg-indigo-700;">
                                Konfirmasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmPayment() {
            let totalHarga = {{ $grandTotal }};
            let totalBayar = document.getElementById('total_bayar').value;
    
            if (totalBayar < totalHarga) {
                Swal.fire({
                    icon: 'error',
                    title: 'Pembayaran Gagal',
                    text: 'Jumlah bayar tidak boleh lebih kecil dari total yang harus dibayar!',
                    confirmButtonColor: '#3085d6', // Ubah tombol OK menjadi biru
                });
                return;
            }
    
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Apakah Anda yakin ingin melakukan pembayaran?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6', // Tombol Konfirmasi (Ya, bayar!) warna biru
                cancelButtonColor: '#d33',    // Tombol Batal warna merah
                confirmButtonText: 'Ya, bayar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('hidden_total_bayar').value = totalBayar;
                    document.getElementById('invoice-form').submit();
                }
            });
        }
    
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#3085d6', // Tombol OK warna biru
            });
        @endif
    
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6', // Tombol OK warna biru
            });
        @endif
    </script>
</x-app-layout>
