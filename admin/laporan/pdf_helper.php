<?php
// PDF Helper untuk generate laporan sederhana
class PDFHelper {
    private $title;
    private $data;
    private $headers;
    private $summaryContent;
    
    public function __construct($title = 'Laporan Scarlett Store') {
        $this->title = $title;
        $this->summaryContent = '';
    }
    
    public function setData($data, $headers) {
        $this->data = $data;
        $this->headers = $headers;
    }
    
    public function addSummary($summary) {
        $this->summaryContent = $summary;
    }
    
    public function generate($filename = 'laporan.pdf') {
        // Create HTML content
        $html = $this->generateHTML();
        
        // Generate PDF using simple method
        $this->htmlToPdf($html);
    }
    
    private function generateHTML() {
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>' . $this->title . '</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    color: #333;
                    font-size: 12px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 2px solid #ff69b4;
                    padding-bottom: 15px;
                }
                .header h1 {
                    color: #d63384;
                    margin: 0;
                    font-size: 24px;
                }
                .header h2 {
                    color: #ff69b4;
                    margin: 5px 0;
                    font-size: 18px;
                }
                .info {
                    margin-bottom: 20px;
                    font-size: 11px;
                    color: #666;
                }
                .summary {
                    background-color: #fff0f5;
                    padding: 15px;
                    border-radius: 5px;
                    margin-bottom: 20px;
                    border: 1px solid #ffcce5;
                }
                .summary h3 {
                    color: #d63384;
                    margin-top: 0;
                    font-size: 14px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                    font-size: 11px;
                }
                th {
                    background-color: #ffcce5;
                    color: #d63384;
                    font-weight: bold;
                }
                tr:nth-child(even) {
                    background-color: #fff0f5;
                }
                .footer {
                    margin-top: 30px;
                    text-align: center;
                    font-size: 10px;
                    color: #666;
                    border-top: 1px solid #ddd;
                    padding-top: 10px;
                }
                @page {
                    margin: 1cm;
                    size: A4 portrait;
                }
                @media print {
                    body { font-size: 12px; }
                    .no-print { display: none !important; }
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>SCARLETT STORE</h1>
                <h2>' . $this->title . '</h2>
            </div>
            
            <div class="info">
                <strong>Tanggal Cetak:</strong> ' . date('d/m/Y H:i:s') . '<br>
                <strong>Dicetak oleh:</strong> Admin System
            </div>';
        
        // Add summary if exists
        if (!empty($this->summaryContent)) {
            $html .= '<div class="summary">
                <h3>Ringkasan Laporan</h3>
                ' . $this->summaryContent . '
            </div>';
        }
        
        // Add table if data exists
        if (!empty($this->data) && !empty($this->headers)) {
            $html .= '<table>';
            
            // Table headers
            $html .= '<tr>';
            foreach ($this->headers as $header) {
                $html .= '<th>' . htmlspecialchars($header) . '</th>';
            }
            $html .= '</tr>';
            
            // Table data
            foreach ($this->data as $row) {
                $html .= '<tr>';
                foreach ($row as $cell) {
                    $html .= '<td>' . htmlspecialchars($cell) . '</td>';
                }
                $html .= '</tr>';
            }
            
            $html .= '</table>';
        }
        
        // Add footer
        $html .= '<div class="footer">
                <p>Laporan ini digenerate otomatis oleh sistem Scarlett Store</p>
                <p>© 2024 Scarlett Store - Sistem Manajemen Produk Kecantikan</p>
            </div>
        </body>
        </html>';
        
        return $html;
    }
    
    private function htmlToPdf($html) {
        // Clear any previous headers
        if (headers_sent()) {
            echo "<script>alert('Headers already sent. Cannot generate PDF.');</script>";
            return;
        }
        
        // Set headers for HTML display
        header('Content-Type: text/html; charset=UTF-8');
        
        // Add improved print script with instructions
        $printScript = '
        <style>
            .print-instructions {
                position: fixed;
                top: 10px;
                right: 10px;
                background: #ff69b4;
                color: white;
                padding: 10px;
                border-radius: 5px;
                font-size: 12px;
                z-index: 1000;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            }
            @media print {
                .print-instructions { display: none; }
            }
        </style>
        <div class="print-instructions">
            <strong>📄 Untuk menyimpan sebagai PDF:</strong><br>
            1. Tekan Ctrl+P (atau Cmd+P di Mac)<br>
            2. Pilih "Save as PDF" sebagai printer<br>
            3. Klik "Save"
        </div>
        <script>
        window.onload = function() {
            // Auto-open print dialog after 1 second
            setTimeout(function() {
                window.print();
            }, 1000);
        };
        </script>';
        
        // Insert print script before closing body tag
        $html = str_replace('</body>', $printScript . '</body>', $html);
        
        echo $html;
    }
}

// Function untuk format rupiah
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// Function untuk format tanggal
function formatTanggal($tanggal) {
    return date('d/m/Y', strtotime($tanggal));
}
?>
