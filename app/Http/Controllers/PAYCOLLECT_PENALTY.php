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
use App\Models\REPAYMENT;


class PAYCOLLECT_PENALTY extends BaseController
{
    function main_void(Request $request)
    {

        $GData = $request->all();
        // dd($GData['list']);
        try {

            // $this->Backup_REPAYMENT($GData['list']);

            $this->Update_PENALTY_COLLECT($GData['list']);

            $this->Update_SUM_AMT($GData['list']);

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


    function Update_PENALTY_COLLECT($list)
    {
        try {
            DB::transaction(function () use ($list) {
                foreach ($list as $value) {
                    REPAYMENT::where('CONTRACT_NUMBER', $value['Contract_number'])
                        ->where('INSTALL', $value['Install'])
                        ->update([
                            'PAY_PENALTY' => (int)$value['Penalty'],
                            'PAY_COLLECT' => (int)$value['Paycollect'],
                        ]);
                }
            });

            DB::commit();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    function Update_SUM_AMT($list)
    {
        try {
            
            DB::transaction(function () use ($list) {

                foreach ($list as $value) {
                    $DB = REPAYMENT::select('PAY_COLLECT', 'PAY_PENALTY', 'PAY_AMT', 'PAY_VAT')
                        ->where('CONTRACT_NUMBER', $value['Contract_number'])
                        ->where('INSTALL', $value['Install'])
                        ->first();
                    // $SUM_AMOUNT = $DB->PAY_COLLECT + $DB->PAY_PENALTY + $DB->PAY_AMT + $DB->PAY_VAT;
                    REPAYMENT::where('CONTRACT_NUMBER', $value['Contract_number'])
                        ->where('INSTALL', $value['Install'])
                        ->update([
                            'PAY_SUM_AMT' => $DB->PAY_COLLECT + $DB->PAY_PENALTY + $DB->PAY_AMT + $DB->PAY_VAT,
                        ]);
                }
            });

            DB::commit();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    function Backup_REPAYMENT($list)
    {
        try {
            foreach ($list as $value) {

                $date_now = Carbon::now(new DateTimeZone('Asia/Bangkok'))->format('Y-m-d H:i:s');

                $DB = DB::table('REPAYMENT')
                    ->select('*')
                    ->where('CONTRACT_NUMBER', $value['Contract_number'])
                    ->where('INSTALL', $value['Install'])
                    ->first();
                // dd($DB);

                DB::table('dbo.REPAYMENT_BACKUP')->insert([
                    "REPAY_ID" => $DB->REPAY_ID,
                    "CONTRACT_ID" => $DB->CONTRACT_ID,
                    "CUSTOMER_CARD_ID" => $DB->CUSTOMER_CARD_ID,
                    "APP_ID" => $DB->APP_ID,
                    "INVOICE_ID" => $DB->INVOICE_ID,
                    "STATUS_ID" => $DB->STATUS_ID,
                    "APPLICATION_NUMBER" => $DB->APPLICATION_NUMBER,
                    "CONTRACT_NUMBER" => $DB->CONTRACT_NUMBER,
                    "CUSTOMER_NAME" => $DB->CUSTOMER_NAME,
                    "REPAY_TYPE" => $DB->REPAY_TYPE,
                    "RECEIPT_NUMBER" => $DB->RECEIPT_NUMBER,
                    "TAX_NUMBER" => $DB->TAX_NUMBER,
                    "PHY_NUMBER" => $DB->PHY_NUMBER,
                    "CREDIT_NOTE_NUMBER" => $DB->CREDIT_NOTE_NUMBER,
                    "PAY_TYPE" => $DB->PAY_TYPE,
                    "MAKE_DATE" => $DB->MAKE_DATE,
                    "REPAY_DATE" => $DB->REPAY_DATE,
                    "REPAY_NAME" => $DB->REPAY_NAME,
                    "REPAY_PENALTY" => $DB->REPAY_PENALTY,
                    "REPAY_COLLECT" => $DB->REPAY_COLLECT,
                    "REPAY_AMOUNT" => $DB->REPAY_AMOUNT,
                    "REPAY_WHT" => $DB->REPAY_WHT,
                    "REPAY_VAT" => $DB->REPAY_VAT,
                    "REPAY_DISCOUNT" => $DB->REPAY_DISCOUNT,
                    "REPAY_SUM_AMOUNT" => $DB->REPAY_SUM_AMOUNT,
                    "DES_SUM_AMT" => $DB->DES_SUM_AMT,
                    "PAY_DATE" => $DB->PAY_DATE,
                    "PAY_NAME" => $DB->PAY_NAME,
                    "PAY_PENALTY" => $DB->PAY_PENALTY,
                    "PAY_COLLECT" => $DB->PAY_COLLECT,
                    "PAY_AMT" => $DB->PAY_AMT,
                    "PAY_VAT" => $DB->PAY_VAT,
                    "PAY_DISCOUNT" => $DB->PAY_DISCOUNT,
                    "PAY_SUM_AMT" => $DB->PAY_SUM_AMT,
                    "INSTALL" => $DB->INSTALL,
                    "OVER_AMT" => $DB->OVER_AMT,
                    "LACK_AMT" => $DB->LACK_AMT,
                    "PENALTY_WAVE_AMT" => $DB->PENALTY_WAVE_AMT,
                    "COLLECT_WAVE_AMT" => $DB->COLLECT_WAVE_AMT,
                    "RESERVE_AMOUNT" => $DB->RESERVE_AMOUNT,
                    "FLAG_RESERVE" => $DB->FLAG_RESERVE,
                    "USE_RESERVE_AMT" => $DB->USE_RESERVE_AMT,
                    "FLAG_EARLY_CLOSE" => $DB->FLAG_EARLY_CLOSE,
                    "CREATE_DATE" => $DB->CREATE_DATE,
                    "UPDATE_DATE" => $DB->UPDATE_DATE,
                    "NAME_MAKE" => $DB->NAME_MAKE,
                    "Backup_Datetime" => $date_now
                ]);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    // function Update_PENALTY_COLLECT($list)
    // {
    //     try {
    //         foreach ($list as $value) {

    //             DB::table('dbo.REPAYMENT')
    //                 ->where('CONTRACT_NUMBER', $value['Contract_number'])
    //                 ->where('INSTALL', $value['Install'])
    //                 ->update([
    //                     'PAY_PENALTY' => (int)$value['Penalty'],
    //                     'PAY_COLLECT' => (int)$value['Paycollect'],
    //                 ]);
    //         }
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }


    // function Update_SUM_AMT($list)
    // {
    //     try {
    //         foreach ($list as $value) {

    //             $DB = DB::table('REPAYMENT')
    //                 ->select('CONTRACT_NUMBER', 'INSTALL', 'PAY_COLLECT', 'PAY_PENALTY', 'PAY_AMT', 'PAY_VAT', 'PAY_SUM_AMT')
    //                 ->where('CONTRACT_NUMBER', $value['Contract_number'])
    //                 ->where('INSTALL', $value['Install'])
    //                 ->first();

    //             // $SUM_AMOUNT = $DB->PAY_COLLECT + $DB->PAY_PENALTY + $DB->PAY_AMT + $DB->PAY_VAT;

    //             DB::table('dbo.REPAYMENT')
    //                 ->where('CONTRACT_NUMBER', $value['Contract_number'])
    //                 ->where('INSTALL', $value['Install'])
    //                 ->update([
    //                     'PAY_SUM_AMT' => $DB->PAY_COLLECT + $DB->PAY_PENALTY + $DB->PAY_AMT + $DB->PAY_VAT,
    //                 ]);
    //         }
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }
}
