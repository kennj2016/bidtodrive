<?php

require $GLOBALS["WEB_APPLICATION_CONFIG"]["resources_path"] . '/vendor/autoload.php';
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/session_model.php");
include_once($GLOBALS["WEB_APPLICATION_CONFIG"]["models_path"] . "/admin_manage_model.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Style;

class AdminTransactions extends FJF_CMD
{

    var $sessionModel = null;

    function __construct()
    {
        $this->sessionModel = new SessionModel();
        $this->setToolTitle('Transactions');
        $this->setToolTitleSingular('Transaction');
    }

    function execute()
    {
        require_once($GLOBALS["WEB_APPLICATION_CONFIG"]["includes_path"] . "/admin_header_commands.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $manager = new AdminManageModel("transactions");
            $manager->registerPostAction("delete");
            if ($messages = $manager->getMessages()) {
                foreach ($messages as $message) {
                    if ($message['error']) $hasError = true;
                    $status .= $message['message'] . "\n";
                }
            }
        }

        $manager = new CustomManager();
        $manager->setOption(array(
            'table' => 'transactions',
            'default_sort' => 'datetime',
            'default_order' => 'desc',
        ));

        $manager->addFilters(array(
            array(
                'id' => 'auction_name',
                'field' => 'auction_name',
                'label' => 'auction name'
            ),
            array(
                'id' => 'buyer_name',
                'field' => 'buyer_name',
                'label' => 'buyer name'
            ),
            array(
                'id' => 'date',
                'field' => 'datetime',
                'type' => 'date'
            ),
            array(
                'id' => 'status',
                'type' => 'select',
                'options' => array(
                    'paid' => 'Paid',
                    'refunded' => 'Refunded'
                )
            )
        ));

        if (isset($_GET["action"]) && $_GET["action"] == "export") {

            $filename = 'transactions-' . time();
            $manager->limit = 0;
            $manager->apply();

            $fields = array(
                "auction_name" => "Auction Name",
                "buyer_name" => "Buyer Name",
                "buyer_email" => "Buyer Email",
                "buyer_phone" => "Buyer Phone",
                "buyer_address" => "Buyer Address",
                "buyer_city" => "Buyer City",
                "buyer_state" => "Buyer State",
                "buyer_zip" => "Buyer Zip",
                "seller_name" => "Seller Name",
                "seller_email" => "Seller Email",
                "seller_phone" => "Seller Phone",
                "seller_address" => "Seller Address",
                "seller_city" => "Seller City",
                "seller_state" => "Seller State",
                "seller_zip" => "Seller Zip",
                "sale_price" => "Sale Price",
                "buyer_fee" => "Buyer Fee",
                "refund_amount" => "Refund Amount",
                "purchasing_agreement" => "Purchasing Agreement",
                "datetime" => "Date",
                "status" => "Status"
            );

            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            $c = 1;
            $r = 1;
            $worksheet->setCellValueByColumnAndRow($c, $r, '#');
            foreach ($fields as $key => $field) {
                $c++;
                $worksheet->setCellValueByColumnAndRow($c, $r, $field);
            }

            if ($manager->rows) {
                foreach ($manager->rows as $record) {
                    $c = 1;
                    $r++;
                    $worksheet->setCellValueByColumnAndRow($c, $r, ($r - 1));
                    foreach ($fields as $field => $title) {
                        $c++;
                        $worksheet->setCellValueByColumnAndRow($c, $r, $record->{$field});
                    }

                }
            }

            $highestColumm = $worksheet->getHighestColumn();
            for ($column = 'A'; $column != $highestColumm; $column++) {
                $worksheet->getColumnDimension($column)->setAutoSize(true);
            }
            $worksheet->getStyle('A1:' . $highestColumm . '1')->getFont()->setBold(true);

            $spreadsheet->setActiveSheetIndex(0);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;


            if ($manager->rows) {
                foreach ($manager->rows as $i => $record) {

                }
            }
//            echo self::generateCSVRow(array_merge(array("#"), $fields));
//            foreach ($this->rows as $i => $record) {
//                $csvRow = array($i);
//                foreach ($fields as $field => $title) $csvRow[] = $record->{$field};
//                echo "\n" . self::generateCSVRow($csvRow);
//            }

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename="' . ($filename ? $filename : 'export-' . time()) . '.csv"');
            $this->rowsToCSV($fields);

        }

        $manager->addCols(array(
            new Id_AdminManagerCol,
            array(
                'id' => 'auction_name',
                'label' => 'auction name',
                'action' => 'view',
                'sort' => 'DESC'
            ),
            array(
                'id' => 'buyer_name',
                'label' => 'buyer name',
                'action' => 'view',
                'sort' => 'DESC'
            ),
            array(
                'id' => 'buyer_fee',
                'label' => 'buyer fee',
                'action' => 'view',
            ),
            array(
                'id' => 'status',
                'label' => 'status',
                'action' => 'view',
            ),
            new DateTime_AdminManagerCol(array(
                    'id' => 'datetime',
                    'label' => 'date',
                    'action' => 'view',
                    'width' => 1
                )
            )
        ));

        $manager->addBatchActions(array(
            'delete'
        ));

        $manager->addRowActions(array(
            new Link_Row_AdminManagerAction(array(
                'id' => 'view',
                'url' => '/admin/transactions/%id%/'
            )),
            'delete'
        ));
        $manager->addCommonActions(array(
            array(
                'id' => 'export',
                'url' => '/admin/transactions/?' . parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY) . '&action=export'
            )
        ));
        $manager->apply();

        if ($this->isAjax()) {
            $data = array('has_more' => $manager->page < $manager->total_pages);
            if ($manager->rows && $_GET['view']) {
                $data['html'] = $this->fetchTemplate("admin_transactions.tpl", array(
                    "view" => $_GET['view'],
                    "manager" => $manager
                ));
            }
            exit(json_encode($data));
        }

        $header['include'] = '<script type="text/javascript" src="/js/admin/cmd/admin_subscribers.js"></script>';

        return $this->displayTemplate("admin_transactions.tpl", array(
            "header" => $header,
            "status" => $status,
            "has_error" => $hasError,
            "manager" => $manager
        ));
    }
}

class CustomManager extends AdminManager
{
    function getRows()
    {
        $rows = parent::getRows();

        if ($rows) {
            foreach ($rows as $row) {
                $row->buyer_fee = "$" . $row->buyer_fee;
                $row->refund_amount = "$" . $row->refund_amount;
            }
        }

        return $rows;
    }

}

?>