@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-shopping-cart"></i> Kasir - Tambah Transaksi
            </div>
            <div class="card-body">
                <form action="{{ route('transactions.store') }}" method="POST" id="form-transaction">
                    @csrf
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered" id="cart-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Pilih Sepatu</th>
                                    <th width="120">Qty</th>
                                    <th width="80">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="item-row">
                                    <td>
                                        <select name="shoes[0][id]" class="form-select shoe-select" required>
                                            <option value="" disabled selected>-- Pilih Sepatu --</option>
                                            @foreach($shoes as $shoe)
                                                <option value="{{ $shoe->id }}" data-price="{{ $shoe->discounted_price }}" data-stock="{{ $shoe->stock }}">
                                                    {{ $shoe->name }} (Stok: {{ $shoe->stock }}) - Rp {{ number_format($shoe->discounted_price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="shoes[0][qty]" class="form-control shoe-qty" min="1" value="1" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger remove-row"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-sm btn-secondary" id="add-row"><i class="fas fa-plus"></i> Tambah Baris</button>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Metode Pembayaran</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="tunai">Tunai</option>
                                <option value="non-tunai">Non-Tunai / Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status Pembayaran</label>
                            <select name="payment_status" id="payment_status" class="form-select" required>
                                <option value="lunas">Lunas</option>
                                <option value="cicilan">Cicilan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row" id="dp-container" style="display: none;">
                        <div class="col-md-6 offset-md-6 mb-3">
                            <label class="form-label fw-bold text-warning">Uang Muka (DP) Cicilan</label>
                            <input type="number" name="down_payment" class="form-control" placeholder="0">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm bg-primary text-white">
            <div class="card-body text-center">
                <h5 class="mb-3">Estimasi Total</h5>
                <h2 class="fw-bold" id="total-display">Rp 0</h2>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowCount = 1;
        const addBtn = document.getElementById('add-row');
        const tbody = document.querySelector('#cart-table tbody');
        const totalDisplay = document.getElementById('total-display');
        const paymentStatus = document.getElementById('payment_status');
        const dpContainer = document.getElementById('dp-container');

        // Tambah Baris
        addBtn.addEventListener('click', function() {
            const tr = document.createElement('tr');
            tr.className = 'item-row';
            tr.innerHTML = `
                <td>
                    <select name="shoes[${rowCount}][id]" class="form-select shoe-select" required>
                        <option value="" disabled selected>-- Pilih Sepatu --</option>
                        @foreach($shoes as $shoe)
                            <option value="{{ $shoe->id }}" data-price="{{ $shoe->discounted_price }}" data-stock="{{ $shoe->stock }}">
                                {{ $shoe->name }} (Stok: {{ $shoe->stock }}) - Rp {{ number_format($shoe->discounted_price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="shoes[${rowCount}][qty]" class="form-control shoe-qty" min="1" value="1" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger remove-row"><i class="fas fa-trash"></i></button>
                </td>
            `;
            tbody.appendChild(tr);
            rowCount++;
            calculateTotal();
        });

        // Hapus Baris & Update Total
        tbody.addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                const tr = e.target.closest('tr');
                if (tbody.querySelectorAll('tr').length > 1) {
                    tr.remove();
                    calculateTotal();
                } else {
                    alert('Minimal harus ada 1 item.');
                }
            }
        });

        tbody.addEventListener('change', calculateTotal);
        tbody.addEventListener('keyup', calculateTotal);

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const select = row.querySelector('.shoe-select');
                const qtyInput = row.querySelector('.shoe-qty');
                
                if (select.value && qtyInput.value) {
                    const price = parseFloat(select.options[select.selectedIndex].getAttribute('data-price')) || 0;
                    const qty = parseInt(qtyInput.value) || 0;
                    total += price * qty;
                }
            });
            totalDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        // Tampilkan input DP jika cicilan
        paymentStatus.addEventListener('change', function() {
            if (this.value === 'cicilan') {
                dpContainer.style.display = 'flex';
            } else {
                dpContainer.style.display = 'none';
            }
        });
    });
</script>
@endsection
