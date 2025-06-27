namespace App\Exports;

use App\Models\Employee;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Crypt;

class EmployeeExport
{
    /**
     * Mengexport data ke format Excel.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download()
    {
        try {
            // Ambil semua data employees
            $employees = Employee::all();

            // Membuat instance Spreadsheet
            $spreadsheet = new Spreadsheet();

            // Menetapkan sheet aktif
            $sheet = $spreadsheet->getActiveSheet();

            // Menetapkan headings
            $headings = [
                'NO', 'Name', 'NIK', 'NIK KTP', 'No KTA', 'Telepon', 'Email', 
                'Alamat KTP', 'Alamat Domisili', 'Status', 'Pendidikan', 
                'TMT', 'Departemen ID', 'Jabatan ID', 'Gada ID', 'TTL', 
                'Nama Ibu', 'Sertifikat', 'BPJS Ketenagakerjaan', 
                'No NPWP', 'Berlaku', 'Keterangan', 'Created At', 'Updated At'
            ];

            // Mengisi header di baris pertama
            foreach ($headings as $key => $heading) {
                $sheet->setCellValueByColumnAndRow($key + 1, 1, $heading);
            }

            // Menambahkan data dari database ke dalam sheet
            $row = 2; // Baris kedua untuk data
            foreach ($employees as $employee) {
                $sheet->setCellValueByColumnAndRow(1, $row, $employee->id);
                $sheet->setCellValueByColumnAndRow(2, $row, $employee->name);
                $sheet->setCellValueByColumnAndRow(3, $row, Crypt::decryptString($employee->nik));
                $sheet->setCellValueByColumnAndRow(4, $row, Crypt::decryptString($employee->nik_ktp));
                $sheet->setCellValueByColumnAndRow(5, $row, Crypt::decryptString($employee->no_regkta));
                $sheet->setCellValueByColumnAndRow(6, $row, Crypt::decryptString($employee->telp));
                $sheet->setCellValueByColumnAndRow(7, $row, $employee->email);
                $sheet->setCellValueByColumnAndRow(8, $row, Crypt::decryptString($employee->alamat_ktp));
                $sheet->setCellValueByColumnAndRow(9, $row, Crypt::decryptString($employee->alamat_domisili));
                $sheet->setCellValueByColumnAndRow(10, $row, $employee->status);
                $sheet->setCellValueByColumnAndRow(11, $row, $employee->pendidikan);
                $sheet->setCellValueByColumnAndRow(12, $row, $employee->tmt);
                $sheet->setCellValueByColumnAndRow(13, $row, $employee->departemen_id);
                $sheet->setCellValueByColumnAndRow(14, $row, $employee->jabatan_id);
                $sheet->setCellValueByColumnAndRow(15, $row, $employee->gada_id);
                $sheet->setCellValueByColumnAndRow(16, $row, $employee->ttl);
                $sheet->setCellValueByColumnAndRow(17, $row, Crypt::decryptString($employee->nama_ibu));
                $sheet->setCellValueByColumnAndRow(18, $row, $employee->sertifikat);
                $sheet->setCellValueByColumnAndRow(19, $row, Crypt::decryptString($employee->bpjsket));
                $sheet->setCellValueByColumnAndRow(20, $row, Crypt::decryptString($employee->no_npwp));
                $sheet->setCellValueByColumnAndRow(21, $row, $employee->berlaku);
                $sheet->setCellValueByColumnAndRow(22, $row, $employee->keterangan);
                $sheet->setCellValueByColumnAndRow(23, $row, $employee->created_at);
                $sheet->setCellValueByColumnAndRow(24, $row, $employee->updated_at);
                $row++;
            }

            // Menyesuaikan lebar kolom
            foreach (range('A', 'X') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            // Membuat writer dan mengirimkan output ke browser
            $writer = new Xlsx($spreadsheet);
            $fileName = 'employees.xlsx';

            return response()->stream(function () use ($writer) {
                $writer->save('php://output');
            }, 200, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="employees.xlsx"',
                'Cache-Control' => 'max-age=0',
            ]);

        } catch (\Exception $e) {
            // Menangani error jika terjadi kesalahan
            return response()->json(['error' => 'Export gagal: ' . $e->getMessage()], 500);
        }
    }
}
