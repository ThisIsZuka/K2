<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use DateTimeZone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\ValidationException;
use stdClass;


class Gen_CancelContract extends BaseController
{
    function __construct()
    {
    }

    public function main_void(Request $request)
    {
        try {
            $GData = $request->all();

            $arr_contract = array_column($GData['list'], 'Contract_number');

            $DB_HCT = DB::table('HISTORY_CALULATE_TERMINATE')
                ->select('CONTRACT_NUMBER', 'CONTRACT_ID')
                ->whereIn('CONTRACT_NUMBER', $arr_contract)
                ->get();

            $arr_DB_HCT = json_decode(json_encode($DB_HCT), true);
            $arr_DB_HCT_contract_number = array_column($arr_DB_HCT, 'CONTRACT_NUMBER');

            if (count($DB_HCT) != 0) {
                // $contract_HCTbackup = array_values(array_unique(array_intersect($arr_contract, $arr_DB_contract_number)));
                $this->Backup_HISTORY_CALULATE_TERMINATE($arr_DB_HCT_contract_number);
            }

            // Back up contract
            $this->Backup_Contract($arr_contract);
            $this->Backup_customer_card($arr_contract);

            $Insert_contract = array_values(array_diff($arr_contract, $arr_DB_HCT_contract_number));
            $this->Insert_History_Calculate_Terminate($Insert_contract);

            $this->Update_History_Calculate_Terminate($GData['list']);

            $this->update_Contract_Status($arr_contract);

            $this->update_customer_card($arr_contract);

            // return true;
            return response()->json([
                'Code' => '0000',
                'message' => "Success",
            ]);
        } catch (Exception $e) {

            // return $e->getMessage();
            return response()->json([
                'Code' => '9000',
                'message' => $e->getMessage(),
            ]);
        }
    }

    function Backup_HISTORY_CALULATE_TERMINATE($arr_DB_contract_number)
    {
        $DB_HISTORY_CAL = DB::table('HISTORY_CALULATE_TERMINATE')
            ->select('*')
            ->whereIn('CONTRACT_NUMBER', $arr_DB_contract_number)
            ->get();

        foreach ($DB_HISTORY_CAL as $value) {

            $date_now = Carbon::now(new DateTimeZone('Asia/Bangkok'))->format('Y-m-d H:i:s');

            DB::table('dbo.HISTORY_CALULATE_TERMINATE_BACKUP')->insert([
                "ID" => $value->ID,
                "CONTRACT_ID" => $value->CONTRACT_ID,
                "CONTRACT_NUMBER" => $value->CONTRACT_NUMBER,
                "CUSTOMER_NAME" => $value->CUSTOMER_NAME,
                "CATEGORY_NAME" => $value->CATEGORY_NAME,
                "BRAND_NAME" => $value->BRAND_NAME,
                "SERIES_NAME" => $value->SERIES_NAME,
                "SUB_SERIES_NAME" => $value->SUB_SERIES_NAME,
                "MODEL_NUMBER" => $value->MODEL_NUMBER,
                "SERIAL_NUMBER" => $value->SERIAL_NUMBER,
                "ACS_DES" => $value->ACS_DES,
                "HP_VAT_SUM" => $value->HP_VAT_SUM,
                "HP_VAT_SUM_TEXT" => $value->HP_VAT_SUM_TEXT,
                "INSTALL_SUM_FINAL" => $value->INSTALL_SUM_FINAL,
                "INSTALL_SUM_FINAL_TEXT" => $value->INSTALL_SUM_FINAL_TEXT,
                "INSTALL_NUM" => $value->INSTALL_NUM,
                "TH_DATE_NOW" => $value->TH_DATE_NOW,
                "TH_DATE_CONTRACT" => $value->TH_DATE_CONTRACT,
                "TH_DATE_FRIST_PAY" => $value->TH_DATE_FRIST_PAY,
                "DUE_DAY" => $value->DUE_DAY,
                "APP_ID" => $value->APP_ID,
                "Install_Num_Final" => $value->Install_Num_Final,
                "Install_AMT" => $value->Install_AMT,
                "Install_PAY" => $value->Install_PAY,
                "SUM_PAY_AMT" => $value->SUM_PAY_AMT,
                "Install_OD_01" => $value->Install_OD_01,
                "Install_OD_02" => $value->Install_OD_02,
                "Install_OD_Sum" => $value->Install_OD_Sum,
                "SUM_OD_AMT" => $value->SUM_OD_AMT,
                "PENALTY_OD" => $value->PENALTY_OD,
                "COLLECT_OD" => $value->COLLECT_OD,
                "SUM_OD_Total" => $value->SUM_OD_Total,
                "Install_Current" => $value->Install_Current,
                "Install_OUTSTAND" => $value->Install_OUTSTAND,
                "SUM_OUTSTAND" => $value->SUM_OUTSTAND,
                "SUM_OUTSTAND_Total" => $value->SUM_OUTSTAND_Total,
                "SUM_PAY_AMT_TEXT" => $value->SUM_PAY_AMT_TEXT,
                "SUM_OD_AMT_TEXT" => $value->SUM_OD_AMT_TEXT,
                "SUM_OD_Total_TEXT" => $value->SUM_OD_Total_TEXT,
                "SUM_OUTSTAND_Total_TEXT" => $value->SUM_OUTSTAND_Total_TEXT,
                "Backup_Datetime" => $date_now,
            ]);
        }
    }

    function Backup_Contract($list)
    {
        $DB_Contract = DB::table('CONTRACT')
            ->select('*')
            ->whereIn('CONTRACT_NUMBER', $list)
            ->get();

        foreach ($DB_Contract as $value) {

            $date_now = Carbon::now(new DateTimeZone('Asia/Bangkok'))->format('Y-m-d H:i:s');

            DB::table('dbo.CONTRACT_BACKUP')->insert([
                "CONTRACT_ID" => $value->CONTRACT_ID,
                "STATUS_ID" => $value->STATUS_ID,
                "STATUS_HP" => $value->STATUS_HP,
                "APP_ID" => $value->APP_ID,
                "PERSON_ID" => $value->PERSON_ID,
                "PARTNER_ID" => $value->PARTNER_ID,
                "P_BRANCH_ID" => $value->P_BRANCH_ID,
                "EMP_ID" => $value->EMP_ID,
                "CIF_PERSON_ID" => $value->CIF_PERSON_ID,
                "PRODUDCT_ID" => $value->PRODUDCT_ID,
                "REPAY_ID" => $value->REPAY_ID,
                "APPLICATION_NUMBER" => $value->APPLICATION_NUMBER,
                "CONTRACT_NUMBER" => $value->CONTRACT_NUMBER,
                "CUSTOMER_NAME" => $value->CUSTOMER_NAME,
                "MAKE_DATE" => $value->MAKE_DATE,
                "CONTRACT_START" => $value->CONTRACT_START,
                "CONTRACT_END" => $value->CONTRACT_END,
                "PERIOD_DATE" => $value->PERIOD_DATE,
                "INSTALL_NUM_FINAL" => $value->INSTALL_NUM_FINAL,
                "OVERDUE" => $value->OVERDUE,
                "ASSIGN_DATE" => $value->ASSIGN_DATE,
                "COLLECTION_NAME" => $value->COLLECTION_NAME,
                "ROLE_COLLECTION" => $value->ROLE_COLLECTION,
                "SERIAL_NUMBER" => $value->SERIAL_NUMBER,
                "CREATE_DATE" => $value->CREATE_DATE,
                "UPDATE_DATE" => $value->UPDATE_DATE,
                "NAME_MAKE" => $value->NAME_MAKE,
                "Backup_Datetime" => $date_now,
            ]);
        }

        // $arr_DB_Contract = json_decode(json_encode($DB_Contract), true);
        // $arr_contract_id = array_column($arr_DB_Contract, 'CONTRACT_ID');

        // return $arr_contract_id;
    }

    function Backup_customer_card($list)
    {
        $DB_customer_card = DB::table('CUSTOMER_CARD')
            ->select('*')
            ->whereIn('CONTRACT_NUMBER', $list)
            ->get();

        foreach ($DB_customer_card as $value) {

            $date_now = Carbon::now(new DateTimeZone('Asia/Bangkok'))->format('Y-m-d H:i:s');

            DB::table('dbo.CUSTOMER_CARD_BACKUP')->insert([
                "ID" => $value->ID,
                "CONTRACT_ID" => $value->CONTRACT_ID,
                "CONTRACT_NUMBER" => $value->CONTRACT_NUMBER,
                "APPLICATION_NUMBER" => $value->APPLICATION_NUMBER,
                "INSTALL_NUM" => $value->INSTALL_NUM,
                "DUEDATE" => $value->DUEDATE,
                "INSTALL_AMT" => $value->INSTALL_AMT,
                "PAY_PRINCIPLE" => $value->PAY_PRINCIPLE,
                "PAY_INTEREST" => $value->PAY_INTEREST,
                "PAY_INSTALL_VAT" => $value->PAY_INSTALL_VAT,
                "OUTSTD_SUM_PRINCIPLE" => $value->OUTSTD_SUM_PRINCIPLE,
                "OUTSTD_SUM_INTEREST" => $value->OUTSTD_SUM_INTEREST,
                "DISCOUNT_AMT" => $value->DISCOUNT_AMT,
                "INVOICE_NUMBER" => $value->INVOICE_NUMBER,
                "RECEIPT_NUMBER" => $value->RECEIPT_NUMBER,
                "SUM_OUTSTAND" => $value->SUM_OUTSTAND,
                "INSTALL_OD_01" => $value->INSTALL_OD_01,
                "INSTALL_OD_02" => $value->INSTALL_OD_02,
                "INSTALL_OD_SUM" => $value->INSTALL_OD_SUM,
                "SUM_OD_AMT" => $value->SUM_OD_AMT,
                "PENALTY_AMT" => $value->PENALTY_AMT,
                "COLLECT_AMT" => $value->COLLECT_AMT,
                "REVENUE_INS_MARGIN" => $value->REVENUE_INS_MARGIN,
                "REVENUE_INS_MARGIN_OUTSTD" => $value->REVENUE_INS_MARGIN_OUTSTD,
                "Backup_Datetime" => $date_now,
            ]);
        }
    }

    function Insert_History_Calculate_Terminate($data)
    {

        $DB_Contract = DB::table('CONTRACT')
            ->select('CONTRACT_ID')
            ->whereIn('CONTRACT_NUMBER', $data)
            ->get();

        $arr_DB_Contract = json_decode(json_encode($DB_Contract), true);
        $arr_contract_id = array_column($arr_DB_Contract, 'CONTRACT_ID');

        foreach ($arr_contract_id as $value) {
            DB::update(DB::raw("exec SP_CalulateTerminate_InsertHistory  @CONTRACT_ID  = '" . $value . "'"));
        }
    }

    function Update_History_Calculate_Terminate($data)
    {
        // $aa = DB::select(DB::raw("select (dbo.Fn_GetMonthFromDateTH(getdate())) as DateTH"))[0]->DateTH;

        foreach ($data as $value) {
            DB::table('dbo.HISTORY_CALULATE_TERMINATE')
                ->where('CONTRACT_NUMBER', $value['Contract_number'])
                ->update([
                    'SUM_PAY_AMT' => $value['SUM_PAY_AMT'],
                    'Install_PAY' => $value['Install_PAY'],
                    'Install_OD_01' => $value['Install_OD_01'],
                    'Install_OD_02' => $value['Install_OD_02'],
                    'Install_OD_Sum' => $value['Install_OD_Sum'],
                    'SUM_OD_AMT' => $value['SUM_OD_AMT'],
                    'SUM_OD_Total' => $value['SUM_OD_Total'],
                    'SUM_OUTSTAND_Total' => $value['SUM_OUTSTAND_Total'],
                    'SUM_PAY_AMT_TEXT' => DB::select(DB::raw("select (dbo.FnConvertTextTHBFull(CAST((" . $value['SUM_PAY_AMT_TEXT'] . " ) as float ))) as TextTHB"))[0]->TextTHB,
                    'SUM_OD_AMT_TEXT' => DB::select(DB::raw("select (dbo.FnConvertTextTHBFull(CAST((" . $value['SUM_OD_AMT_TEXT'] . " ) as float ))) as TextTHB"))[0]->TextTHB,
                    'SUM_OD_Total_TEXT' => DB::select(DB::raw("select (dbo.FnConvertTextTHBFull(CAST((" . $value['SUM_OD_Total_TEXT'] . " ) as float ))) as TextTHB"))[0]->TextTHB,
                    'SUM_OUTSTAND_Total_TEXT' => DB::select(DB::raw("select (dbo.FnConvertTextTHBFull(CAST((" . $value['SUM_OUTSTAND_Total_TEXT'] . " ) as float ))) as TextTHB"))[0]->TextTHB,
                    'TH_DATE_NOW' => DB::select(DB::raw("select (dbo.Fn_GetMonthFromDateTH(getdate())) as DateTH"))[0]->DateTH,
                ]);
        }
    }


    function update_Contract_Status($data)
    {
        foreach ($data as $value) {
            DB::table('dbo.CONTRACT')
                ->where('CONTRACT_NUMBER', $value)
                ->update([
                    'STATUS_ID' => '54',
                ]);
        }
    }

    function update_customer_card($data)
    {
        foreach ($data as $value) {
            DB::table('dbo.CUSTOMER_CARD')
                ->where('CONTRACT_NUMBER', $value)
                ->whereNull('INVOICE_NUMBER')
                ->update([
                    'INVOICE_NUMBER' => '1',
                ]);
        }
    }
}
