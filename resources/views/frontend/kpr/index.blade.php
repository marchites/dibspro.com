@extends('layouts.app')

@section('title', 'Kalkulator KPR')

@section('content')

<div class="section">

    <div class="row justify-content-center">

        <div class="col-lg-12">

            <div class="card shadow border-0 rounded-4">

                <div class="card-body p-4">

                    <h2 class="fw-bold mb-4">
                        Kalkulator KPR
                    </h2>

                    <div class="mb-3">
                        <label class="form-label">Harga Properti</label>
                        <input type="number"
                               id="price"
                               class="form-control"
                               value="500000000">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            DP (%)
                        </label>

                        <input type="range"
                               id="dpRange"
                               min="0"
                               max="90"
                               value="20"
                               class="form-range">

                        <div>
                            <span id="dpPercent">20</span>%
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Suku Bunga (% per tahun)
                        </label>

                        <input type="number"
                               id="interest"
                               class="form-control"
                               step="0.1"
                               value="8">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Tenor (Tahun)
                        </label>

                        <select id="tenor"
                                class="form-select">

                            <option value="5">5 Tahun</option>
                            <option value="10">10 Tahun</option>
                            <option value="15" selected>15 Tahun</option>
                            <option value="20">20 Tahun</option>
                            <option value="25">25 Tahun</option>
                        </select>
                    </div>

                    <hr>

                    <h4 class="mb-3">
                        Hasil Simulasi
                    </h4>

                    <table class="table">

                        <tr>
                            <th>DP</th>
                            <td id="dpValue">Rp0</td>
                        </tr>

                        <tr>
                            <th>Jumlah Pinjaman</th>
                            <td id="loanValue">Rp0</td>
                        </tr>

                        <tr>
                            <th>Cicilan per Bulan</th>
                            <td id="monthlyPayment"
                                class="fw-bold text-success">
                                Rp0
                            </td>
                        </tr>

                        <tr>
                            <th>Total Pembayaran</th>
                            <td id="totalPayment">Rp0</td>
                        </tr>

                        <tr>
                            <th>Total Bunga</th>
                            <td id="totalInterest">Rp0</td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function formatRupiah(number)
{
    return 'Rp' + new Intl.NumberFormat('id-ID').format(
        Math.round(number)
    );
}

function calculateKPR()
{
    const price =
        parseFloat(
            document.getElementById('price').value
        ) || 0;

    const dpPercent =
        parseFloat(
            document.getElementById('dpRange').value
        ) || 0;

    const interest =
        parseFloat(
            document.getElementById('interest').value
        ) || 0;

    const tenor =
        parseInt(
            document.getElementById('tenor').value
        ) || 0;

    document.getElementById('dpPercent')
            .innerText = dpPercent;

    const dpValue =
        price * (dpPercent / 100);

    const loan =
        price - dpValue;

    const monthlyRate =
        (interest / 100) / 12;

    const totalMonths =
        tenor * 12;

    let monthlyPayment = 0;

    if(monthlyRate > 0)
    {
        monthlyPayment =
            loan *
            (
                monthlyRate *
                Math.pow(
                    1 + monthlyRate,
                    totalMonths
                )
            ) /
            (
                Math.pow(
                    1 + monthlyRate,
                    totalMonths
                ) - 1
            );
    }

    const totalPayment =
        monthlyPayment * totalMonths;

    const totalInterest =
        totalPayment - loan;

    document.getElementById('dpValue')
            .innerText =
            formatRupiah(dpValue);

    document.getElementById('loanValue')
            .innerText =
            formatRupiah(loan);

    document.getElementById('monthlyPayment')
            .innerText =
            formatRupiah(monthlyPayment);

    document.getElementById('totalPayment')
            .innerText =
            formatRupiah(totalPayment);

    document.getElementById('totalInterest')
            .innerText =
            formatRupiah(totalInterest);
}

document.querySelectorAll(
    '#price,#dpRange,#interest,#tenor'
).forEach(element =>
{
    element.addEventListener(
        'input',
        calculateKPR
    );
});

calculateKPR();

</script>

@endsection