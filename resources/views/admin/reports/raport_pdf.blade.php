<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Raport Siswa - {{ $student->name }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1e293b;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
            color: #1e293b;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 4px;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th, .data-table td {
            border: 1px solid #94a3b8;
            padding: 8px;
            text-align: center;
        }
        .data-table th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            font-size: 11px;
        }
        .data-table td.text-left {
            text-align: left;
        }
        .summary-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .summary-box td {
            border: 1px solid #94a3b8;
            padding: 10px;
            vertical-align: top;
        }
        .footer {
            width: 100%;
            margin-top: 50px;
        }
        .signature-box {
            width: 30%;
            float: right;
            text-align: center;
        }
        .signature-line {
            margin-top: 70px;
            border-bottom: 1px solid #000;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN HASIL BELAJAR SISWA</h1>
        <p>Tahun Ajaran {{ $academicYear->year }} - Semester {{ $academicYear->semester_type }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="info-label">Nama Siswa</td>
            <td>: {{ $student->name }}</td>
            <td class="info-label">Kelas</td>
            <td>: {{ $classroom->name }} ({{ $classroom->major->name ?? 'Umum' }})</td>
        </tr>
        <tr>
            <td class="info-label">NISN / Email</td>
            <td>: {{ $student->email }}</td>
            <td class="info-label">Wali Kelas</td>
            <td>: {{ $classroom->teacher->name ?? '-' }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Mata Pelajaran</th>
                <th width="20%">Nilai Akhir</th>
                <th width="30%">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left">{{ $row['subject']->name }}</td>
                <td><strong>{{ number_format($row['score'], 1) }}</strong></td>
                <td><strong>{{ $row['predicate'] }}</strong></td>
            </tr>
            @endforeach
            @if(count($reportData) === 0)
            <tr>
                <td colspan="4">Belum ada data nilai akademik.</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: right; font-weight: bold; border: 1px solid #94a3b8; padding: 8px;">Rata-rata Kelas</td>
                <td style="font-weight: bold; border: 1px solid #94a3b8; padding: 8px;">{{ number_format($averageScore, 1) }}</td>
                <td style="border: 1px solid #94a3b8;"></td>
            </tr>
        </tfoot>
    </table>

    <table class="summary-box">
        <tr>
            <td width="50%">
                <strong>Ketidakhadiran (Absensi)</strong><br><br>
                <table style="width: 100%; font-size: 11px;">
                    <tr><td width="60%">Sakit</td><td>: {{ $attendances['S'] }} Hari</td></tr>
                    <tr><td>Izin</td><td>: {{ $attendances['I'] }} Hari</td></tr>
                    <tr><td>Tanpa Keterangan (Alpa)</td><td>: {{ $attendances['A'] }} Hari</td></tr>
                    <tr><td><strong>Total Hadir</strong></td><td><strong>: {{ $attendances['H'] }} Hari</strong></td></tr>
                </table>
            </td>
            <td width="50%">
                <strong>Keterangan Predikat</strong><br><br>
                <table style="width: 100%; font-size: 11px;">
                    <tr><td width="40%">90 - 100</td><td>: A (Sangat Baik)</td></tr>
                    <tr><td>80 - 89</td><td>: B (Baik)</td></tr>
                    <tr><td>70 - 79</td><td>: C (Cukup)</td></tr>
                    <tr><td>< 70</td><td>: D (Kurang)</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="footer">
        <div style="float: left; width: 30%; text-align: center;">
            <p>Mengetahui,<br>Orang Tua/Wali</p>
            <div class="signature-line"></div>
        </div>
        
        <div class="signature-box">
            <p>Diberikan di: Jakarta<br>Tanggal: {{ $date }}</p>
            <p>Wali Kelas</p>
            <div class="signature-line"></div>
            <p style="margin-top: 5px;">{{ $classroom->teacher->name ?? '.......................' }}</p>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>
